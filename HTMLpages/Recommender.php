<?php
	include('../config/connectDB.php');
	session_start();
	$college_id = $_SESSION['college_id'];
	echo $college_id;
	echo "<br>";
	$sql = "select mem_id from member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql);
	$mem_ids = mysqli_fetch_assoc($result);
	$mem_id = $mem_ids['mem_id'];
	mysqli_free_result($result);
	$search_book_name = '';
	$error = '';
	$availableBooks = true;
	$notavailableBooks=true;
   	if(isset($_POST['gr_button']))
	{
		$gr_num = mysqli_real_escape_string($conn, $_POST['gr_button']);
		
		$_SESSION["gr_no"] = $gr_num;
		header('Location: BookDetails.php');
	}
	if(isset($_GET['search_book']))
	{
		$search_book_name = mysqli_real_escape_string($conn, $_GET['search_book']);
	}
	else
	{
		$search_book_name = '';
	}
	$sql = "SELECT book.gr_no,book.name,book.rating,book.category,copy.status
 			from book,copy,record where book.gr_no = copy.gr_no and copy.gr_no = record.gr_no and copy.conditions=1 and book.name like '%$search_book_name%'
 			and book.gr_no not in
			(SELECT gr_no 
			from record
			where record.issued_by = $mem_id)
			group by record.gr_no order by count(*) desc";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0)
	{
		$books1 = mysqli_fetch_all($result);
	}
	else
	{
		$availableBooks = false;
	}
	mysqli_free_result($result);
	//echo $sql;
	//print_r($books1);
/*SELECT count(*),book.gr_no,book.name,book.rating,book.category,copy.status
 from book,copy,record where book.gr_no = copy.gr_no and copy.gr_no = record.gr_no and copy.conditions=1
 and book.gr_no not in
 (SELECT gr_no 
 from record
 where record.issued_by = 3)
 group by record.gr_no,copy.copy_no order by count(*) desc;*/
	if(!$availableBooks)
	{
		$error = "No Such book exists";
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Reccomendations</title>
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

		
			
<form action="Recommender.php" method="GET">	
<div class="container" style="margin-top:40px">
				
  <input class="form-control" id="anythingSearch" type="text" name="search_book" placeholder="Type something to search list items">
  <div id="myDIV" style="margin-top:20px">
  <input type="submit" name="search" class = "btn btn-primary" value="Search">
    <input class="btn btn-info" type="submit" name="" value="Clear">
  </div>
</div>

		
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
		<table class = "table table-striped table-responsive-md btn-table" style = "border:collapse";>
			<tr>
				<th>GR number</th>
				<th>Book Name
				<th>Rating</th>
				<th>Genre</th>
				<th>Author</th>
				<th>Availability</th>

			</tr>
				<?php
					if($availableBooks):
						foreach($books1 as $book):
				?>
						<tr>
	                     <form action="Recommender.php" method="POST">
	      					<td>
	      						<input type="submit" name="gr_button" class = "btn btn-dark btn-sm" value="<?php echo $book[0]; ?>" > 
	      					</td>
	                    	</form>	
				
                    	<?php
                      //  
						//echo "<td>". $book[0]."</td>";
						echo "<td>". $book[1] ."</td>";
						echo "<td>". $book[2] ."</td>";
						echo "<td>". $book[3]." </td>";
						//echo "<td>". $book[4]." </td>"; 
						$sql = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$book[0]')";
						$result = mysqli_query($conn, $sql);
						$authors = mysqli_fetch_all($result);
				?>
						<td>
							<table>
				<?php
							foreach ($authors as $author):
								echo "<tr>";
									echo "<td>";
									echo $author[0] . " " . $author[1];
									echo "</td>";
								echo "</tr>";
							endforeach;
				?>
							</table>
						</td>
				<?php
						if($book[4]==1)
						{
							echo "<td> Available </td>";
						}
						else
						{
							echo "<td>". "Reserved" ."</td>";
						}
				?>
						</tr>
				<?php
						endforeach;
					endif;
					if(!$availableBooks):
						echo "<tr><td>".$error."</td></tr>";
					endif;
				?>
			</tr>
				

	
				</table>
				</div>
	
	</body>
				</html>
<?php 
	mysqli_close($conn);
?>
	
