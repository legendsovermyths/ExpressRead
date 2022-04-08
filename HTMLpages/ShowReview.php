<?php 
session_start();
	
	$my_gr_no = $_SESSION['my_gr_no'];
	include('../config/connectDB.php');
	$availablerecord = true;
	$counter=0;
     $sql1 = "select b.name from book b where b.gr_no='$my_gr_no'";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$bookname =$infos['name'];
	mysqli_free_result($result);

    $sql="select review from record where gr_no='$my_gr_no' and review is not null";
     $result = mysqli_query($conn, $sql);

			
			if(mysqli_num_rows($result) > 0)
			{
				$reviewinfo = mysqli_fetch_all($result);
			}
			else
			{
				$availablerecord = false;
			}
			mysqli_free_result($result);

  ?>
  <!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Return</title>
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
<h3 style = "text-transform: capitalize;margin-top: 2%;"> <center><?php echo $bookname; ?></center></h3>


      <?php 
     
					
					if($availablerecord):
						foreach( $reviewinfo as $review):
				?>	
				<?php

						echo "<p style = 'margin: 2%' class='note note-light'>". $review[0]."</p>";

						
				?>
				<p style = "margin-left: 20px" >
				   
				<?php
						endforeach;
						else:
							{
                               echo "  nothing to show!";  
							}
						
						 endif;

                 ?>
             </p>


</body>
</html>