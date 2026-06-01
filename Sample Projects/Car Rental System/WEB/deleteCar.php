
<?php
include_once 'connect.php';
$db = new mysqli;
$carID=$_GET['carID'];

$sql = "DELETE FROM car WHERE carID='$carID'";

$val =$conn->query($sql);

header('location: car.php');


?>






