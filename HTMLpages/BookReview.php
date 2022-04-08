<?php 

session_start();
	$accession_id = $_SESSION['accession_id'];
	include('../config/connectDB.php');
   $sql1 = "select r.gr_no,b.name from record r,book b where r.accession_id='$accession_id' and r.gr_no=b.gr_no";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$gr_no = $infos['gr_no'];
	$bname =$infos['name'];
	mysqli_free_result($result);


      if(isset($_POST['submit']))
      {
         
      	$data= mysqli_real_escape_string($conn, $_POST['data']);
      	
        $sql="update record set review='$data' where accession_id='$accession_id'";
          mysqli_query($conn, $sql);
        $rate= mysqli_real_escape_string($conn, $_POST['rating']);
      	
        $sql01="update record set rating='$rate' where accession_id='$accession_id'";
          mysqli_query($conn, $sql01);

        $sql02="update book set rating=(select AVG(rating) from record r where r.gr_no='$gr_no') where book.gr_no='$gr_no' ";
                mysqli_query($conn, $sql02);
      }
      

 ?>
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
<div class = "text-center">
	<form action="BookReview.php" method="POST">
    <div style="padding-left:7%;padding-right:7%;padding-top:7%;">
	<table class="table table-bordered border-dark">
		<tr>
			<td>Book Id</td>
			<?php  echo "<td>". $gr_no ."</td>"; ?>
			
		</tr>
		<tr>
			<td>Book Name</td>
			<?php  echo "<td>". $bname ."</td>"; ?>
		</tr>	
         <tr>
			<td>Enter book review</td>
			
				<td>
					<input type = "text" class="form-control" placeholder = "enter the review" name = "data" value = "">
				</td>
		</tr>
		<tr>
			<td>Give book a Rating</td>
			
				<td>
					<input type = "text" class="form-control" placeholder = "enter rating (out of 5)" name = "rating" value = "">
				</td>
		</tr>

	</table>
    </div>
	<input type="submit" name="submit" class = "btn btn-info btn-lg" value="submit">
  </form>
</div>
</body>
</html>