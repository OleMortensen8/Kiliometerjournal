<?php 
class Table{
    private string $table = "<p>Data kommer snart</p>";
    private $allTogether;
    private float $fuelConsumptionRate = 4.20168; // liters per 100 km

    public function getFuelConsumptionRate(): float
    {
        return $this->fuelConsumptionRate;
    }

    //  public function getFuelCapacity()
    //  {
    //     return $this->fuelCapacity;
    //  }

    public function calculateFuelUsed($kmDriven): float
    {
        $fuelUsed = ($kmDriven / 100) * $this->getfuelConsumptionRate();
        return round($fuelUsed, 2); // Round to one decimal place
    }

    public function createTable($lists, $TotalPerMonth): void
    {
      $this->table = '<thead>
      <tr>
          <th>Initialer</th>
          <th>km - Start</th>
          <th>km - stop</th>
          <th>km kørt</th>
          <th>registreret</th>
          <th>Diesel Brugt</th>
          <th>Rute Prisen</th>
          <th>Brændstof tilbage (L)</th>  
      </tr>
  </thead>'. '<tbody>';
// make their own function/method
    foreach($lists as $list){
    $this->table .="<tr>".
        "<td>" . $list["Initialer"] . "</td>" .
        "<td>" . $list["KmStart"] . "</td>" .
        "<td>" . $list["KmSlut"] . "</td>" .
        "<td>" . $list["SamledeKmTal"] . "</td>" .
        "<td>" . $list["Dato"] . "</td>" .
        "<td>" . ($kmDriven = $this->calculateFuelUsed($list["SamledeKmTal"])) . " L</td>" .
        "<td>" . round(($kmDriven * 11.89), 2) . " DKK" . "</td>" .
        "<td>" . $list["FuelRemaining"] . " L</td>" .
        "<td> <form action='' method='post'>
        <button class='btn btn-danger' type='submit' name='data' value='". $list['EntryID'] ." '>Delete</button>
    </form></td>".
        "</tr>";
    }

    $this->table .= '</tbody>';

        // make their own function/method
        $this->allTogether = $TotalPerMonth;


        $maaneder = array("", "Januar", "Febuar", "Marts", "April", "Maj", "Juni", "Juli", "August", "September", "Oktober", "November", "December");
    $pos = date("n", strtotime("now"));
        $this->table .= '<tfoot class="footer-row">';
        foreach ($TotalPerMonth as $total) {
            $this->table .= '<tr><th scope="row">Kørt på i <br/>';
            $this->table .= $maaneder[ltrim($total['month'], '0')] . ' ' . date('Y', strtotime('now')) . '</th><td>' . $total['total'] . ' km</td></tr>';
        }
        $this->table .= '</tfoot>';
    }

    public function getTable(): string
    {
        return $this->table;
     }

    }