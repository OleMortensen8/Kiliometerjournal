<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="assets/css/main.css">
<title></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
<div id="wrap">
    <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container"><a class="navbar-brand logo" href="/">Kiliometer Journalen i PHP</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div
                class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link active" href="/">Kiliometer instastninger</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="features.php">Kilometer liste</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="stats.php">Statisik</a></li>
<?php if (isset($_SESSION['user_id'])) { ?>
    <li class="nav-item" role="presentation"><a class="nav-link" href="logout.php">LogOut</a></li>

<?php  }?>
                </ul>
        </div>
        </div>
    </nav>