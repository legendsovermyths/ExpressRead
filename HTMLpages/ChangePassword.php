<?php 
session_start();
	$college_id = $_SESSION['college_id'];

include('../config/connectDB.php');
$sql1="select password from member where college_id='$college_id'";
$result1=mysqli_query($conn, $sql1);
$fetchedpassword = mysqli_fetch_row($result1);


if(isset($_POST['change']))
{
	$old = mysqli_real_escape_string($conn, $_POST['OldPassword']);
	$new = mysqli_real_escape_string($conn, $_POST['NewPassword']);
	$renew = mysqli_real_escape_string($conn, $_POST['ReNewPassword']);
	if($fetchedpassword[0] != $old)
	{
		echo "you have entered wrong current password";
	}
	else if($new==$renew)
	{
		    $sql="update member set password='$new' where college_id='$college_id' and password='$old'";
		    $result = mysqli_query($conn, $sql);
	}
	else
	{
		echo "new password and confirm password doesn't match";
	}
	


}

 ?>
 <!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Sign Up Page</title>
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  rel="stylesheet"
/>
<!-- Google Fonts -->
<link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
  rel="stylesheet"
/>
<!-- MDB -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css"
  rel="stylesheet"
/>
		<!-- <link rel="stylesheet"  href="../CSS/styles.css"> -->
	</head>
	<body>
        <!-- MDB -->
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"
></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
     <!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark ">
  <!-- Container wrapper -->
  <div class="container-fluid" style="padding-left:7%;">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="#">ExpressRead</a>

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- Link -->
        <li class="nav-item">
          <a class="nav-link" href="./userhomepage.php">Back</a>
        </li>

      </ul>

    </div>
  </div>
  <!-- Container wrapper -->
</nav>
<div style="padding-left:7%;padding-right:7%;padding-top:7%;" class = "text-center">
<table class="table table-borderless">
<form action="ChangePassword.php" method="POST">
		
			<tr>
				<td>Enter current Password: </td>
				<td><div class = "textbox">
		 	<input type = "password" class="form-control form-control-lg" placeholder = "Old Password" name = "OldPassword" >
		 </div></td>
			</tr>
			<tr>
				<td>Enter new Password: </td>
				<td>
					<div class = "textbox">
		 	<input type = "password" class="form-control form-control-lg"  placeholder = "New Password" name = "NewPassword" >
		 </div>
				</td>
			</tr>
			<tr>
				<td>Confirm new Password: </td>
				<td>
					<div class = "textbox">
		 	<input type = "password" class="form-control form-control-lg" placeholder = "New Password" name = "ReNewPassword" >
		 </div>
				</td>
			</tr>
		<tr><td>
		<input type="submit" name="change" class = "btn btn-lg btn-warning" value="SUBMIT"></td></tr>
   </form>
</table>
</div>		

	</body>