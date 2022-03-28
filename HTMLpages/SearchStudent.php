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
    $sql1 = "select designation,mem_id from member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql1);
	$infos = mysqli_fetch_assoc($result);
	$desig = $infos['designation'];
	$mem_id=$infos['mem_id'];
	mysqli_free_result($result);
  if(true)
	{
		    $sql01="select count(*) from record r where issued_by='$mem_id' and return_date is NULL";
		         $result01 = mysqli_query($conn, $sql01);
			$i1 = mysqli_fetch_assoc($result01);
			$n1 = $i1['count(*)'];
			
		if($n1==0)
	    {

				    $sql2 = "select count(*) from record where issued_by = '$mem_id'";
					$result = mysqli_query($conn, $sql2);
					$info = mysqli_fetch_assoc($result);
					$num = $info['count(*)'];

					mysqli_free_result($result);
				    if($num>0)
				     {
						$sql3 = "delete from record where issued_by='$mem_id'";
				         mysqli_query($conn, $sql3);

					}

					if($desig=="admin" || $desig=="head_librarian")
					{

				         $sql4="update record set returned_by=NULL where returned_by='$mem_id'";
				                  mysqli_query($conn, $sql4);

					}




						$sql = "delete from member where college_id='$college_id'";
						if(mysqli_query($conn, $sql))
						{
							//echo "entry altered <br>";
						}
						else 
						{
					  		echo "error altering values: " . mysqli_error($conn) . "<br />";
						}
		}

		else
		{
			echo "can't remove user, because ".$college_id." is still to return an issued book ";
		}	
	}	
}


$sql1 = "select college_id,name,designation,phone,email,fine_due from member where verification_status=1 ";
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

  
   if($search_by=="college_id")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where college_id like '%$data%' and verification_status=1 order by mem_id";
   }
   if($search_by=="name")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where name like '%$data%' and verification_status=1  order by mem_id";
   }
   if($search_by=="designation")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where designation like '%$data%' and verification_status=1  order by mem_id";
   } 
   if($search_by=="phone")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where phone like '%$data%' and verification_status=1  order by mem_id";
   }
   if($search_by=="email")
   {
    $sql = "select college_id,name,designation,phone,email,fine_due from member where email like '%$data%' and verification_status=1  order by mem_id";
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
<form action="SearchStudent.php" method="POST">
<div class="container" style="margin-top:40px">
  <input class="form-control" id="anythingSearch" type="text" name="data" placeholder="Type something to search list items">
  <div id="myDIV" style="margin-top:20px">
  <input type="submit" name="search" class = "btn btn-primary" value="search">
    <button class="btn btn-info" type="submit" name="">Clear</button>
  </div>
  <div class="form-check form-check-inline" style="margin-top:20px">
  <input class="form-check-input" type="radio" id="name" name="search_on" value="name" />
  <label class="form-check-label" for="inlineRadio1">By Name</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="genre" name="search_on" value="college_id" />
  <label class="form-check-label" for="inlineRadio2">By College ID</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="rating" name="search_on" value="designation" />
  <label class="form-check-label" for="inlineRadio3">By Designation</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="auth1" name="search_on" value="phone" />
  <label class="form-check-label" for="inlineRadio3">By Phone Number</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="auth1" name="search_on" value="email" />
  <label class="form-check-label" for="inlineRadio3">By Email</label>
</div>
</div>
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
</form>
<table class="table table-striped table-responsive-md btn-table">
<thead>
  <tr>
    <th>College ID</th>
    <th>Name</th>
    <th>Designation</th>
    <th>Phone</th>
	<th>Email</th>
	<th>Fine due</th>
  </tr>
</thead>
<?php 
     
					
	 if($availablerecord):
		 foreach( $studentinfo as $student):
 ?>
		 <tr>
 <?php
		 echo "<td>". $student[0]."</td>";
		 echo "<td>". $student[1] ."</td>";
		 echo "<td>". $student[2] ."</td>";
		 echo "<td>". $student[3] ."</td>";
		 echo "<td>". $student[4] ."</td>";
		 echo "<td>". $student[5] ."</td>";

		 
 ?>
	<form action="SearchStudent.php" method="GET">
<td><input type="submit" name="<?php echo $student[0]?>" class = "buttons" value="Remove"> </td>
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