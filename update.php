<?php
require 'include/conn.php';
if (isset($_POST["id"])){
  var_dump($_POST);
  $data = [
    'fname' => $_POST["firstName"],
    'lname' => $_POST["lastName"],
    'age' => $_POST["age"],
    'id' => $_POST["id"],
  ];
  $stmt = $conn->prepare("UPDATE people SET first_name = :fname, last_name = :lname, age = :age WHERE id = :id");
  $stmt->execute($data);
  $stmt = null;
}
