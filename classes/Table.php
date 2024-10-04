<?php 
class Table{
    private string $table = "<p>Data kommer snart</p>";
    private $allTogether;
    private float $fuelConsumptionRate = 8.8; // liters per 100 km

    // private float $fuelCapacity = 44; // liters

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

    public function createTable($lists): void
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
      </tr>
  </thead>'. '<tbody>';
// make their own function/method
    foreach($lists as $list){
    $this->table .="<tr>".
        "<td>". $list["initialer"]."</td>" .
        "<td>". $list["kmStart"] ."</td>" .
        "<td>". $list["kmSlut"] ."</td>" .
        "<td>". $list["samledeKmTal"] ."</td>".
        "<td>". $list["dato"] ."</td>".
        "<td>" . ($kmDriven = $this->calculateFuelUsed($list["samledeKmTal"])) . " L</td>" .
        "<td>" . round(($kmDriven * 12.89), 2) . " DKK" . "</td>" .
        "<td> <form action='' method='post'>
        <button class='btn btn-danger' type='submit' name='data' value='". $list['EntryID'] ." '>Delete</button>
    </form></td>".
        "</tr>";
    }

    $this->table .= '</tbody>';

// make their own function/method
    foreach($lists as $list){
          $this->allTogether += $list["samledeKmTal"];
        }
    $maaneder = array("","Januar","Febuar","Marts","April","Maj","Juni","Juli","August","Okttober","September","November","December");
    $pos = date("n", strtotime("now"));
    $this->table .= '<tfoot><th scope="row">Kørt på i ';
    $this->table .= $maaneder[$pos] . '</th><td>'. $this->allTogether .' km</td></tfoot>';  
    }

    public function getTable(): string
    {
        return $this->table;
     }

    }