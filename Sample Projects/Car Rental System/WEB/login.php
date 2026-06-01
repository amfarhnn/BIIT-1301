
<?php

session_start();

include ("connect.php");
?>



<?php

if (isset($_POST['submit']))
{

	$adminID=mysqli_real_escape_string($conn, $_POST ['adminID']);
	$password=mysqli_real_escape_string($conn, $_POST ['password']);
	//$password= md5($password);


	$query = "SELECT * FROM admin WHERE adminID='$adminID' && adminPswrd = '$password'";
	$data = mysqli_query ($conn,$query);
	$total = mysqli_num_rows ($data);
	if ($total == 1)
	{
		$_SESSION ['admin_id']=$adminID;
    $query="SELECT * FROM admin WHERE adminID='$adminID'";
		$result =mysqli_query ($conn,$query);
		if (mysqli_num_rows($result) >0 )
		{
			while ($row =mysqli_fetch_assoc($result)):

			if (isset($row['adminName'])&& isset ($row['adminContact']) ) {

				$name1 = $row ['adminName'];
				$phone1=$row['adminContact'];
        $adminID=$row['adminID'];

				$_SESSION['name'] = $name1;
        $_SESSION['adminID'] = $adminID;

				$_SESSION['phone'] = $phone1;




}

endwhile;
}
		header ('location:./report.php');



    }

	else


	echo "<script>alert('wrong email or password..please log in again')</script>";
	//header ('location:login.php');
	echo "<script>window.location = 'login.php'</script>";



}




?>


























<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>haiCar <a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" name="login" method="post">
        <div class="input-group mb-3">
          <input type="input" class="form-control" placeholder="user ID" name= "adminID" id="adminID" >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name= "password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">

          <!-- /.col -->
          <div class="col-4">
            <button type="submit"  name="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>
