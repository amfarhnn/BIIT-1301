
<?php
include_once 'connect.php';
$db = new mysqli;
$clientID=$_GET['clientID'];

$sql = "DELETE FROM client WHERE clientID='$clientID'";

$val =$conn->query($sql);

header('location: customers.php');


?>






