<?php
require "include/conn.php";
if (!isset($_POST["fname"])) header('Location: index.php');

$stmt = $conn->prepare("INSERT INTO people VALUES (null, :firstname, :lastname, :age)");
$stmt->execute([":firstname" => $_POST["fname"], ":lastname" => $_POST["lname"], ":age" => $_POST["age"]]);
$stmt = null;
header('Location: index.php');