<?php
session_start()

?>



<?php
$db = new mysqli;
include ("connect.php");
//if($db){ echo "connection success";}




$sql = "SELECT * from client ";
$val=$conn->query($sql);
//$val=$db->query($sql);
$rows=$val;
$result = $conn->query($sql);
$query = $conn->query($sql);

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> List of Customers</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./report.php" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>

      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
        </div>
        <div class="info">
          <a href="#" class="d-block"> Hi, <?php echo 	$_SESSION['name'] ?> </a>
        </div>
      </div>

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
            <a href="./blank.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                List of Booking

              </p>
            </a>
          <li class="nav-item">
            <a href="./car.php" class="nav-link">
              <i class="nav-icon fas fa-car"></i>
              <p>
                List of car

              </p>
            </a>

          <li class="nav-item">
            <a href="./customers.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                List of Customers

              </p>
            </a>
          </li>
          </li>
          <li class="nav-item">
            <a href="./logout.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Logout

              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>WELCOME TO ADMIN PANEL</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Customers</a></li>

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">LIST OF CUSTOMERS</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
              <table class="table m-0">
                <thead>
                  <tr>
                  <tr>
                    <th>Client ID</th>
                    <th>Client Name</th>
                    <th>Contact</th>
                    <th>Address</th>

                    <th>Frequency of booking </th>
                    <th>Total spent </th>


                    <th>Action </th>
                  </tr>
                  </tr>
                </thead>
                <tbody>
                <tr>


                  <?php while( $row = mysqli_fetch_array($result)){ ?>

<td ><?php echo $row['clientID']; $clientID= $row['clientID'];;?></td>
<td ><?php echo $row['clientName'];?></td>
<td ><?php echo $row['clientContact'];?></td>
<td><?php echo $row['clientAdr'];?></td>

<td ><?php $res=mysqli_query($conn,"SELECT count(*) as total from booking WHERE clientID='$clientID'");
$data=mysqli_fetch_assoc($res);
echo $data['total']; ?></td>

<td > RM <?php $res=mysqli_query($conn,"SELECT SUM(totalPayment) as total from payment WHERE clientID='$clientID'");
$data=mysqli_fetch_assoc($res);
echo $data['total']; ?></td>

<html>
<body>

<!--form method="post" action="acceptreject.php?reserveID= <?php echo $row['reserveID'];?>">
<td>
<select  name="status">
<option value="Pending">Pending</option>
<option value="Accept">Accept</option>
<option value="Reject">Reject</option>
</select></td> -->
<td> <a  href="deleteClient.php?clientID=<?php echo $row['clientID'];?>" class ="btn btn-danger" name="submit" >Delete</a></td>
<td> <a href="updateClient.php?clientID=<?php echo $row['clientID'];?>" class ="btn btn-success"   >update</a></td>

</form>

</tr>
<?php } ?>



                </tbody>

              </table>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          Footer
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.1.0-pre
    </div>
    <strong>Copyright &copy; 2022 <a href="https://adminlte.io">HaiCar</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
</body>
</html>
