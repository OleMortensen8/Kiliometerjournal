<?php 
include('classes/autoload.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    function sendData($db, $ini, $kmStart, $kmStop, $refuel = null)
    {
        if (isset($ini) && isset($kmStart) && isset($kmStop)) {
            $samledetal = $kmStop - $kmStart;
            $Fuelused = $db->calculateFuelUsed($samledetal);
            if (isset($refuel)) {
                $FuelRemaining = DB::FULL_TANK_CAPACITY - $Fuelused;
            } else {
                $FuelRemaining = $db->calculateSubtractedLiters($Fuelused);
            }
            $db->sendsDataToSql($ini, $kmStart, $kmStop, $samledetal, $FuelRemaining);

        }
    }

    if (isset($_POST['data'])) {
        $data = $_POST['data'];
        $db->deleteEntry($data);
    }

    if (isset($_POST['submit'])) {
        sendData($db, $_POST['ini'], $_POST['kmStart'], $_POST['kmStop']);
    } elseif (isset($_POST['refuel'])) {
        sendData($db, $_POST['ini'], $_POST['kmStart'], $_POST['kmStop'], $_POST['refuel']);
    }
}
include('views/header.php');