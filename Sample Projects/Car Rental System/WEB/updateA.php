<?php


session_start();
?>


<?php
$db = new mysqli;
$db->connect('localhost','root','','carrental');


$bookingID=$_GET['bookingID'];


$sql = "SELECT b.* ,  c.* FROM booking b  left join client c  on b.clientID=c.clientID where  bookingID='$bookingID'";

$rows=$db->query($sql);

$row=$rows->fetch_assoc();

//var_dump($row);

if(isset($_POST['update'])){

    $returnDate=$_POST['returnDate'];
    $bookingStatus=$_POST['bookingStatus'];

  $sql = "UPDATE booking SET returnDate='$returnDate',bookingStatus='$bookingStatus' WHERE bookingID='$bookingID' ";

  $db->query($sql);



    header('location: blank.php');


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
                <h1>Update Booking Details</h1>
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


           			Booking ID:  <input type="text" name="roomName" class="form-control" id="newtask" value="<?php echo $row['bookingID'];?> "readonly>
                   client  Name:  <input type="text" name="roomName" class="form-control" id="newtask" value="<?php echo $row['clientName'];?>"readonly>
                  Return Date:  <input type="date" name="returnDate" class="form-control" id="newtask" value="<?php echo $row['returnDate'];?>">

                 <label  for="bookingStatus"> Booking Status</label>
                            <select class="form-control" id="bookingStatus" name="bookingStatus">
                            <option  class="form-control" value="Car returned">Car returned</option>
                            <option class="form-control" value="Ongoing">Ongoing</option>

                            </select>




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
