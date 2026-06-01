<?php


session_start();
?>


<?php
$db = new mysqli;
$db->connect('localhost','root','','carrental');


$carID=$_GET['carID'];


$sql = "SELECT *  from car where carID='$carID'";

$rows=$db->query($sql);

$row=$rows->fetch_assoc();

//var_dump($row);

if(isset($_POST['update'])){

    $carName=$_POST['carName'];

    $carType=$_POST['carType'];
    $carCapacity=$_POST['carCapacity'];
    $carColour=$_POST['carColour'];
    $carPlate=$_POST['carPlate'];
    $carBrand=$_POST['carBrand'];
    $carYear=$_POST['carYear'];
    $carStatus=$_POST['carStatus'];
    $carNotes=$_POST['carNotes'];
    $carPrice=$_POST['carPrice'];
     echo $carYear;

  $sql = "UPDATE car SET carName='$carName',carBrand='$carBrand',carType='$carType',carCapacity='$carCapacity',carColour='$carColour',carPlate='$carPlate',carYear='$carYear'
  ,carStatus='$carStatus',carNotes='$carNotes',carPrice='$carPrice'
 WHERE carID='$carID' ";

  $db->query($sql);





    header('location: car.php');

}


?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


</head>

<body>
    <div class="container">
        <div class="row">
            <div class="mx-auto" style="width: 200px;">
                <h1>Update Car Details</h1>
            </div>
            <div class="col-md-10 col-md-offset-3">
                <p></p>

                <!-- Button trigger modal -->
                <!-- Button trigger modal -->

<!--                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Add </button>-->


<!--                <button type="button" class="btn btn-outline-dark" "float-right" onclick="window.print()">Print List</button>-->
                <p></p>

                <form method="POST">
                    <div class="form-group">

                  Car ID:  <input type="text" name="roomName" class="form-control" id="newtask" value="<?php echo $row['carID'];?> "readonly>
                  Car Name  :  <input type="text" name="carName" class="form-control" id="newtask" value="<?php echo $row['carName'];?>">
                  Brand:  <input type="text" name="carBrand" class="form-control" id="newtask" value="<?php echo $row['carBrand'];?>">
                  Type:  <input type="text" name="carType" class="form-control" id="newtask" value="<?php echo $row['carType'];?>">
                  Capacity:  <input type="text" name="carCapacity" class="form-control" id="newtask" value="<?php echo $row['carCapacity'];?>">
                  Colour:  <input type="text" name="carColour" class="form-control" id="newtask" value="<?php echo $row['carColour'];?>">
                  Plate:  <input type="text" name="carPlate" class="form-control" id="newtask" value="<?php echo $row['carPlate'];?>">
                  Year:  <input type="text" name="carYear" class="form-control" id="newtask" value="<?php echo $row['carYear'];?>">

                <label  for="carStatus">Status</label>
                            <select class="form-control" id="carStatus" name="carStatus">
                            <option  class="form-control" value="AVAILABLE">AVAILABLE</option>
                            <option class="form-control" value="NOT AVAILABLE">NOT AVAILABLE</option>

                            </select>



                  Price(RM):  <input type="text" name="carPrice" class="form-control" id="newtask" value="<?php echo $row['carPrice'];?>">

                  Notes:  <input type="text" name="carNotes" class="form-control" id="newtask" value="<?php echo $row['carNotes'];?>">





                    </div>
                  <button type="submit" name="update" class="btn btn-primary">Save</button>
                </form>


            </div>

        </div>

    </div>






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
