<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sideTitlen = 'KilometerJournalen i PHP';
include('bootstrap.php');

$db = new DB(); // Assuming DB is the class name for database operations
$table = new Table(); // Assuming Table is the class name for table operations

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$totalEntries = $db->getTotalEntries();
$totalPages = ceil($totalEntries / $limit);

$data = $db->getDataToSql($limit, $offset);

$TotalPerMonth = $db->getTotalPerMonth();

?>

    <main class="page">
        <section class="clean-block features">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info" style="letter-spacing:0px;"><a href="features.php"><strong>KILOMETER
                                LISTE</strong></a><br></h2>
                    <p>Her er et overblik over alle instastede kørseler</p>
                </div>
                <div>
                    <div class="table-responsive">
                        <div id="printableArea">
                            <table class="table">
                                <?php $table->createTable($data, $TotalPerMonth);
                                if ($data) {
                                    echo $table->getTable();
                                } else {
                                    echo '<p style="text-align:center;">Data Kommer Snart</p>';
                                }
                                ?>
                            </table>
                        </div>
                        <?php if ($data) { ?>
                            <button class="btn btn-primary" type="button" onclick="printDiv('printableArea')"><img src="printer.svg"/></button>
                            <div>Icons made by <a href="https://www.flaticon.com/authors/simpleicon" title="Printer">Printer</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
                            <script>
                                function printDiv(divName) {
                                    var printContents = document.getElementById(divName).innerHTML;
                                    var originalContents = document.body.innerHTML;
                                    document.body.innerHTML = printContents;
                                    window.print();
                                }
                            </script>
                        <?php } ?>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </section>
    </main>
<?php include('views/footer.php'); ?>