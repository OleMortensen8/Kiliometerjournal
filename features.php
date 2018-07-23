<?php $sideTitlen = 'Kilometer liste'; 
 include('bootstrap.php');?>
    <main class="page">
        <section class="clean-block features">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info" style="letter-spacing:0px;"><a href="https://bootstrapstudio.io/app/features.html"><strong>KILOMETER LISTE</strong></a><br></h2>
                    <p>Her er et overblik over alle instastede kørseler</p>
                </div>
                <div>
                    <div class="table-responsive">
                        <table class="table">
                  <?php $table->createTable($db->getDataToSql());
                   if($db->getDataToSql()){
                    echo $table->getTable();
                    }else{
                    echo '<p style="text-align:center;">Data Kommer Snart</p>';
                    }
                    ?>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
  <?php include('views/footer.php'); ?>