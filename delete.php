<?php
require 'include/conn.php';
if (isset($_POST["id"]) and is_numeric($_POST["id"])){
  $stmt = $conn->prepare("DELETE FROM people WHERE id=:id");
  $stmt->execute([':id' => $_POST['id']]);
  $stmt = null;
}
