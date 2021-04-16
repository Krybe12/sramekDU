<?php
session_start();
require "include/conn.php";

$sql = "CREATE TABLE IF NOT EXISTS people (
  id int AUTO_INCREMENT,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  age int NOT NULL,
  PRIMARY KEY (id)
);";
$conn->exec($sql);
header('Location: index.php');