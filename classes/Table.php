<?php 
class Table{
    private $table = "<p>Data kommer snart</p>";
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
    foreach($lists as $list){
    $this->table .="<tr>".
        "<td>". $list["initialer"]."</td>" .
        "<td>". $list["kmStart"] ."</td>" .
        "<td>". $list["kmSlut"] ."</td>" .
        "<td>". $list["samledeKmTal"] ."</td>".
        "<td>". $list["dato"] ."</td>".
        "<td><button class='btn btn-danger' id='". $list['EntryID']. "'>Delete</button></td>".
        "</tr>";
    }
        '</tbody>';

    }

    public function getTable(){
        return $this->table;
     }

    }
?>