<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sideTitlen = 'KiliometerJournalen i PHP';
include('bootstrap.php');
$lastStopKm = new DB();
?>
<main class="page landing-page">
    <section class="clean-block clean-hero"
             style="background-image:url('assets/img/tech/image4.jpg');color:rgba(9, 162, 255, 0.85);">
        <div class="text">
            <h1><?php echo "Welcome to your dashboard!"; ?></h1>
            <h2>Kiliometer Log</h2>
            <p>Intast dine Initialer og Kilometer tal her. Dine samlede Kilometer tal og data kan ses på listen</p>
            <form action="" method="POST">
                <input type="hidden" name="ini" value="<?php echo $_SESSION['username']; ?>">
                <label>Km - Start</label>
                <input class="form-control" name="kmStart" id="kmStart" type="text"
                       value="<?php $lastStopKm->getlastStopKm(); ?>">
                <label>Km - Stop</label>
                <input class="form-control" name="kmStop" type="text">
                <button class="btn btn-danger" type="submit" name="refuel"
                        style="display:inline-block; margin-top:25px;padding-top:10px; padding-right:10px;padding-bottom:6px;padding-left:10px;">
                    Refuel
                </button>
                <button class="btn btn-primary" type="submit" name="submit"
                        style="margin-top:25px;padding-top:10px; padding-right:10px;margin-right:251px;padding-bottom:6px;padding-left:10px;background-color:rgb(0,25,255);">
                    Submit
                </button>
            </form>
        </div>
    </section>

    <!-- Include jQuery before your script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var kmStartValue = $('#kmStart').val();
            console.log('kmStartValue:', kmStartValue); // Debugging output
            if (kmStartValue) {
                $('#kmStart').attr('readonly', true);
            }
        });
    </script>
</main>
<?php include('views/footer.php'); ?>

