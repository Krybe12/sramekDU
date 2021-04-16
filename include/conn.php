<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "test";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e){
  echo "Connection failed: " . $e->getMessage();
}

?>
