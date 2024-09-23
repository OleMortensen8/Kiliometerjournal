<?php
// login.php
require 'csrf.php';
require 'bootstrap.php';

$pdo = new DB();
$pdo = $pdo->DBCONNECT();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate the CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        echo "Invalid CSRF token!";
        exit();
    }

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Username and Password are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Regenerate CSRF token after login
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }
}
?>

<main style="width:18%; margin: 160px auto 0;">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo getCsrfToken(); ?>">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($username ?? ''); ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</main>
