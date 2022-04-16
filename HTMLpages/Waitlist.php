<?php 

include('../config/connectDB.php');
$search_by="";
$data="";
$availablerecord = true;
 

$sql="";
$flag=0;
$flipped_get = array_flip($_GET);
	//echo "<br>";
	//print_r($flipped_get);
if(isset($flipped_get['Remove']))
{
		//echo $flipped_get['Remove'];
	$college_id = mysqli_real_escape_string($conn, $flipped_get['Remove']);
    $sql1 = "select gr_no,mem_id from waitlist where mem_id = '$college_id'";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$desig = $infos['gr_no'];
	$mem_id=$infos['mem_id'];
	echo "$mem_id";
	mysqli_free_result($result);
	$sql = "delete from waitlist where mem_id='$college_id'";
	if(mysqli_query($conn, $sql))
	{
		// echo "entry altered <br>";
	}
	else 
	{
		  echo "error altering values: " . mysqli_error($conn) . "<br />";
	}
}


$sql1 = "select mem_id, gr_no,priority_no from waitlist ";

$result1 = mysqli_query($conn, $sql1);
$studentinfo=  mysqli_fetch_all($result1);
mysqli_free_result($result1);



if(isset($_POST['search']))
{ 
	if(isset($_POST['search_on']))
	{
		$search_by = mysqli_real_escape_string($conn, $_POST['search_on']);
		$data= mysqli_real_escape_string($conn, $_POST['data']);
		
	}
   else
   { $flag=1;
   	
   }

  
   if($search_by=="MEMBER")
   {
    $sql = "select mem_id, gr_no,priority_no from waitlist  where mem_id like '%$data%'";
   }
   if($search_by=="BOOK")
   {
    $sql = "select mem_id, gr_no,priority_no from waitlist  where gr_no like '%$data%'";
   }
   
   if($sql!="")
   {
			$result = mysqli_query($conn, $sql);

			
			if(mysqli_num_rows($result) > 0)
			{
				$studentinfo = mysqli_fetch_all($result);
			}
			else
			{
				$availablerecord = false;
			}
			mysqli_free_result($result);
   }
   else
   {
   	$availablerecord = false;
   }

}

 ?>
 <!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Waitlist</title>
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
<form action="Waitlist.php" method="POST">
<div class="container" style="margin-top:40px">
  <input class="form-control" id="anythingSearch" type="text" name="data" placeholder="Type something to search list items">
  <div id="myDIV" style="margin-top:20px">
  <input type="submit" name="search" class = "btn btn-primary" value="search">
    <button class="btn btn-info" type="submit" name="">Clear</button>
  </div>
  <div class="form-check form-check-inline" style="margin-top:20px">
  <input class="form-check-input" type="radio" id="name" name="search_on" value="MEMBER" />
  <label class="form-check-label" for="inlineRadio1">By MEMBER</label>
</div>

<div class="form-check form-check-inline" style="margin-top:20px">
  <input class="form-check-input" type="radio" id="genre" name="search_on" value="BOOK" />
  <label class="form-check-label" for="inlineRadio2">By BOOK ID</label>
</div>


</div>
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
</form>
<table class="table table-striped table-responsive-md btn-table">
<thead class='table-dark'>
  <tr>
    <th>College ID</th>
    <th>Name</th>
    <th>Phone</th>
	<th>Book</th>
	<th>Email</th>
	<th>Priority Number</th>
	<th>Action</th>
  </tr>
</thead>
<?php 
     
					
	 if($availablerecord):
		 foreach( $studentinfo as $student):
 ?>
		 <tr>
 <?php
         $sql2 ="select name, phone, college_id, email from member where mem_id=$student[0]";
		 $result2 = mysqli_query($conn, $sql2);
         $studentinfo2=  mysqli_fetch_all($result2);
         mysqli_free_result($result2);
		 $sql3 ="select name from book where gr_no=$student[1]";
		 $result3 = mysqli_query($conn, $sql3);
         $studentinfo3=  mysqli_fetch_all($result3);
         mysqli_free_result($result3);
		 echo "<td>". $studentinfo2[0][2]."</td>";
		 echo "<td>". $studentinfo2[0][0]."</td>";
		 echo "<td>". $studentinfo2[0][1]."</td>";
		 echo "<td>". $studentinfo3[0][0]."</td>";
		 echo "<td>". $studentinfo2[0][3]."</td>";
		 echo "<td>". $student[2] ."</td>";

		 
 ?>
	<form action="Waitlist.php" method="GET">
<td><input type="submit" name="<?php echo $student[0]?>" class = "btn btn-sm btn-danger" value="Remove"> </td>
	 </form>
		 </tr>
 <?php
		 endforeach;
		 else:
			 {
				if($flag==1)
					 echo "please select the search criteria --> ";

				echo "  nothing to show!";  
			 }
		 
		  endif;

  ?>
 


</table>
</body>
</html>