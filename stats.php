<?php include('bootstrap.php'); ?><main style="width:60%; margin: 160px auto 0;">
<!-- Canvas element for Chart.js -->
    <h1>Statisik</h1>
<canvas id="myChart" width="250" height="80"></canvas>

<?php
$conn = new PDO('sqlite:kiliometerlistesqlite.db');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare('SELECT dato, samledeKmTal FROM kiliometerliste');
$stmt->execute();

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    const dataReceived = <?php echo json_encode($rows); ?>;
    console.log(dataReceived);

    const labels = dataReceived.map(function(e) {
        return e.dato;
    });
    const data = dataReceived.map(function(e) {
        return e.samledeKmTal;
    });

    console.log(labels);
    console.log(data);

    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Samlede Km Tal',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</main>
