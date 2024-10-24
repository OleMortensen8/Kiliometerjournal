<?php
// register.php
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
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "All fields are required.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        if ($stmt->execute([$username, $hashed_password])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Regenerate CSRF token after registration
            header("Location: login.php");
            exit();
        } else {
            echo "Registration failed.";
        }
    }
}
?>

<main style="width:18%; margin: 160px auto 0;">
    <h2>Register</h2>
    <p>Please fill in this form to create an account.</p>

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
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Register">
        </div>
    </form>
</main>
