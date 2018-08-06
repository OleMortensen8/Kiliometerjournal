<?php 
class Table{
    private $table = "<p>Data kommer snart</p>";
    private $allTogether;
    public function createTable($lists){
      $this->table = '<thead>
      <tr>
          <th>Initialer</th>
          <th>km - Start</th>
          <th>km - stop</th>
          <th>km kørt</th>
          <th>registreret</th>
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

    public function getTable(){
        return $this->table;
     }

    }
?>