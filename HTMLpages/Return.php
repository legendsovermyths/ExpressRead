<?php 
session_start();
	$college_id = $_SESSION['college_id'];
	include('../config/connectDB.php');
	$availablerecord = true;

    
$flipped_get = array_flip($_GET);

if(isset($flipped_get['Return']))
	{
		
		$accessionid = mysqli_real_escape_string($conn, $flipped_get['Return']);
         $sql1 = "select b.gr_no,c.copy_no,r.issued_by from record r,copy c,book b where r.accession_id = '$accessionid' and b.gr_no=c.gr_no and b.gr_no=r.gr_no and c.copy_no=r.copy_no";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$grno = $infos['gr_no'];
	$copyno =$infos['copy_no'];
	$issued_by=$infos['issued_by'];
	mysqli_free_result($result);
	$sql2 = "update copy set status=1 where copy.gr_no='$grno' and copy.copy_no='$copyno'";
         mysqli_query($conn, $sql2);
    $sql22 = "update member set fine_due=0 where mem_id='$issued_by'";
         mysqli_query($conn, $sql22);
    $sql4 = "select mem_id from member where college_id='$college_id'";
	$result = mysqli_query($conn, $sql4);
	$data1 = mysqli_fetch_assoc($result);
	$mem_id = $data1['mem_id'];
	mysqli_free_result($result);

     $sql3 = "update record set returned_by='$mem_id' where accession_id='$accessionid'";
         mysqli_query($conn, $sql3);  

     $strt_d = strtotime("today");
	 $today_date = date("Y/m/d", $strt_d); 
	   $sql5 = "update record set return_date='$today_date' where accession_id='$accessionid'";
         mysqli_query($conn, $sql5);
    $sql = "SELECT issued_by from record where accession_id = $accessionid";
    $result = mysqli_query($conn, $sql); 
    $issuedByArr = mysqli_fetch_assoc($result);
	$issued_by = $issuedByArr['issued_by'];
	mysqli_free_result($result);
    $sql = "select email,name,college_id from member where mem_id = $issued_by";
	$result = mysqli_query($conn, $sql); 
  	$emailArr = mysqli_fetch_assoc($result);
	$email = $emailArr['email'];
	$name = $emailArr['name'];
	$college_id_issued = $emailArr['college_id'];
	mysqli_free_result($result);
	$sql = "Select name from book where gr_no = '$grno'";
  	$result = mysqli_query($conn, $sql); 
  	$bookNameArr = mysqli_fetch_assoc($result);
	$bookName = $bookNameArr['name'];
	mysqli_free_result($result);
	$sql1 = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$grno')";
	$result1 = mysqli_query($conn, $sql1);
	$authors = mysqli_fetch_all($result1);
	mysqli_free_result($result1);
	$auth = '';
	foreach ($authors as $author):
		$auth .= $author[0] . " " . $author[1] . ", ";
	endforeach;
    $to_email = "$email";
	$subject = "Return Book Email";
	$headers = "From: expressreadlibrary@gmail.com\r\n";
	//$headers .= "CC: susan@example.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$body = "
	<html>
	<head>
	  <title>Issue Book Email</title>
	</head>
	<body>
	  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Express Read Library</b></p><br>
	  <p>Dear $name($college_id_issued)<br>
	  The following book has been returned by you today.<br>
	  <table style='border: 1px solid black;'>
	  <thead>
	  <tr>
	  <th style='border: 1px solid black;'>Book ID</th>	
	  <th style='border: 1px solid black;'>Book Title</th>
	  <th style='border: 1px solid black;'>Author</th>
  
	  <th style='border: 1px solid black;'>Accession ID</th>
	   </tr>
		 </thead>
		 <tr><td style='border: 1px solid black;'>$grno</td>
		 <td style='border: 1px solid black;'>$bookName</td>
		 <td style='border: 1px solid black;'>".substr($auth, 0, -2)."</td>
		 <td style='border: 1px solid black;'>$accessionid</td>
		 </tr>
		 </table>
	  <br>
	  You are welcome to contact us at expressreadlibrary@gmail.com for any Queries.
	  <br>
	  Regards,
	  <br>
	  Librarian
	  </p>
	</body>
	</html>
	";
	if (mail($to_email, $subject, $body, $headers)) {
	    echo "Email successfully sent to $to_email...";
	} else {
	    echo "Email sending failed...";
	}

	
	}
	$sql = "SELECT r.accession_id,m.college_id,b.gr_no,c.copy_no,b.name,r.due_date,m.fine_due  FROM member m,record r,book b,copy c where 
    r.gr_no=c.gr_no and  r.copy_no=c.copy_no  and b.gr_no=c.gr_no and r.issued_by=m.mem_id and r.return_date is NULL
    order by r.accession_id ";
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
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
<table class="table table-striped table-responsive-md btn-table">

<thead class='table-dark'>
  <tr>	
    <th>Accession id</th>
 		<th>User id</th>
 		<th>Book id</th>
 		<th>Copy  no.</th>
 		<th>Book name</th>
 		<th>Due date</th>
 		<th>Fine due</th>
 		<th>Return Book</th>
  </tr>
</thead>
<?php 
     
					
					if($availablerecord):
						foreach( $recordinfo as $record):
				?>
						<tr>
				<?php
						echo "<td>". $record[0]."</td>";
						echo "<td>". $record[1] ."</td>";
						echo "<td>". $record[2] ."</td>";
						echo "<td>". $record[3] ."</td>";
						echo "<td>". $record[4] ."</td>";
						echo "<td>". $record[5]."</td>";
						echo "<td>". $record[6]."</td>";
					
						
				?>
				   <form action="Return.php" method="GET">
      <td><center><input type="submit" class="btn btn-sm btn-warning" name="<?php echo $record[0]?>" class = "buttons" value="Return"> </center></td>
                    </form>
						</tr>
						
				<?php
						endforeach;
						else:
							{
                         
                               echo "<tr><td colspan=\"8\">nothing to return!</td></tr>";  
							}
						
						 endif;

                 ?>
 </table>

</body>