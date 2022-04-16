<?php  
	session_start();
	$college_id = $_SESSION['college_id'];

	include('../config/connectDB.php');

	$flipped_get = array_flip($_GET);
	if(isset($flipped_get['Review & Rate']))
	{
		$_SESSION['accession_id'] = $flipped_get['Review & Rate'];
		header('Location: BookReview.php'); 
	}
	$availablerecord = true;
    $sql = "SELECT r.accession_id,b.name,r.issue_date,r.due_date,COALESCE(r.return_date,'not returned')  FROM member m,record r,book b,copy c where 
    r.gr_no=c.gr_no and  r.copy_no=c.copy_no  and b.gr_no=c.gr_no and r.issued_by=m.mem_id and m.college_id='$college_id' order by r.return_date,r.due_date desc ";
	$result = mysqli_query($conn, $sql);

	
	if(mysqli_num_rows($result) > 0)
	{
		$recordinfo = mysqli_fetch_all($result);
	}
	else
	{
		$availablerecord = false;
	}
	mysqli_free_result($result);
	if($college_id==NULL)
	{
		session_destroy();
		header('Location: ../index.php');
	}
 ?>
 <!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>History</title>
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

<form>
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
<table class="table table-striped table-responsive-md btn-table">

<thead class="table-dark">
  <tr>
    <th>Accession ID</th>
    <th>Book Name</th>
    <th>Date of issue</th>
    <th>Due Date</th>
	<th>Return Date</th>
	<th>Action</th>
  </tr>
</thead>
<?php 
     
					
					if($availablerecord):
						foreach( $recordinfo as $recordrow):
				?>
						<tr>
				<?php
						echo "<td>". $recordrow[0]."</td>";
						echo "<td>". $recordrow[1] ."</td>";
						echo "<td>". $recordrow[2] ."</td>";
						echo "<td>". $recordrow[3]." </td>";
						echo "<td>". $recordrow[4]." </td>";
				?>
						<td>
							<input type="submit" class="btn btn-info btn-sm" name="<?php echo $recordrow[0]?>" value = "Review & Rate">
						</td>

						

						</tr>
				<?php
						endforeach;
						else:
							echo " <tr><td colspan=\"5\">nothing to show as ".$college_id ." has not read any book yet!!</td></tr>";
						 endif;

                 ?>

					
				
</table>
</form>
</body>
</html>
