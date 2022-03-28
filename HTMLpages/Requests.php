<?php
	include('../config/connectDB.php');
	session_start();
	$college_id = '';
	$error = '';
	//print_r($_GET);
	$flipped_get = array_flip($_GET);
	//echo "<br>";
	//print_r($flipped_get);
	if(isset($flipped_get['Accept']))
	{
		//echo $flipped_get['Accept'];
		$college_id = mysqli_real_escape_string($conn, $flipped_get['Accept']);
		$sql = "update member set verification_status=1 where college_id = '$college_id'";
		if(mysqli_query($conn, $sql))
		{
			//echo "entry altered <br>";
		}
		else 
		{
	  		echo "error altering values: " . mysqli_error($conn) . "<br />";
		}
	}
	if(isset($flipped_get['Reject']))
	{	
		//echo $flipped_get['Reject'];
		$college_id = mysqli_real_escape_string($conn, $flipped_get['Reject']);
		$sql = "delete from member where college_id='$college_id'";
		if(mysqli_query($conn, $sql))
		{
			//echo "entry deleted <br>";
		}
		else 
		{
	  		echo "error deleting values: " . mysqli_error($conn) . "<br />";
		}
	}
	// echo $_SESSION['college_id'];
	$sql = '';
	if($_SESSION['college_id']=='LIBRARY')
		$sql = "select name,phone,email,designation,college_id from member where verification_status = 0 order by designation";
	else
		$sql = "select name,phone,email,designation,college_id from member where verification_status = 0 and designation!='admin' order by designation";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0)
	{
		$users = mysqli_fetch_all($result);
	}
	else
	{
		$error = "No user Requests";
	}
	//print_r($users);
	//echo "<br> $error <br>";
	$college_id = '';
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Requests</title>
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
<form action="Requests.php" method="GET">
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
<table class="table table-striped table-responsive-md btn-table">
<?php 
		 	if($error=='')
		 	{
		 ?>


<thead>
  <tr>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Designation</th>
	<th>College ID</th>
  </tr>
</thead>
<?php
			 	foreach($users as $user)
			 	{
			 		echo "<tr>";
			 		foreach($user as $user_data)
			 		{
			 			echo "<td>$user_data</td>";
			 		}
		 ?>
		 	<td>
		 		<!-- <input type="hidden" name="id_to_delete" value = "<?php //echo $user[4]?>"> -->
		 		<input type="submit" class="btn btn-success btn-sm" name="<?php echo $user[4]?>" value="Accept">
		 	</td>
		 	<td>
		 		<input type="submit"  class="btn btn-danger btn-sm" name="<?php echo $user[4]?>" value="Reject">
		 	</td>
		 <?php
		 			echo "</tr>";
		 		/*echo "<td>$user[0]</td>";
		 		echo "<td>$user[1]</td>";
		 		echo "<td>$user[2]</td>";
		 		echo "<td>$user[3]</td>";*/
		 		}
		 	}
		 	else
		 		echo "<td>$error</td>";
		 ?>
	</table>
</form>
 	
</body>