<?php
require "include/conn.php";
?>
<?php
class Tablinator{
  public function __construct($result){
    $this->data = "";
    $this->createHeader(array_keys($result[0]));
    $this->createBody($result);
    $this->createFooter($result);
  }
  private function createHeader(array $headers){
    $this->data .= "<table class='table'><thead><tr>";
    foreach($headers as $header){
      $this->data .= "<th>$header</th>";
    }
    $this->data .= "<th>cudliky</th>";
    $this->data .= "</tr></thead>";
  }
  private function createBody(array $result){
    foreach($result as $row){
      $rowId = $row["id"];
      $this->data .= "<tr data-id='$rowId'>";
      foreach($row as $val){
        $this->data .= "<td>$val</td>";
      }
      $this->data .= $this->btnTemplate($rowId);
      $this->data .= "</tr>";
    }
    $this->data .= "</tbody></table>";
  }
  private function btnTemplate(int $id){
    return "<td><button type='button' data-id='$id' class='btn-edit button is-small'>E</button><button type='button' data-id='$id' class='btn-del button is-small ml-1'>D</button></td>";
  }
  private function createFooter(array $result){
    $this->data .= count($result) . " rows in set";
  }
  public function echoTable(){
    return json_encode($this->data);
  }
}
$result = $conn->query("select * from people;");
if (!$result->rowCount()) {echo json_encode("empty set"); return;};
$table = new Tablinator($result->fetchAll());
echo $table->echoTable();
?>