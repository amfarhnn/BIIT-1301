
<?php
include_once 'connect.php';
$db = new mysqli;
$bookingID=$_GET['bookingID'];

$sql = "DELETE FROM booking WHERE bookingID='$bookingID'";

$val =$conn->query($sql);
header('location: blank.php');


?>






