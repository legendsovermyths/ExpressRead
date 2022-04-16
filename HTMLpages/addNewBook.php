<?php
	include('../config/connectDB.php');
	$title='';
	$gr_no='';
	$error = '';
	$publisher='';
	$publisher_contact = '';
	$publisher_email = '';
	$author = '';
	$shelf = '';
	$section = '';
	$floor = '';
	$category = '';
	$disableInput = false;
	$problem = false;
	if(isset($_GET['gr_search']))
	{
		$gr_no = mysqli_real_escape_string($conn,$_GET['gr_no']);
		$sql = "SELECT name from book where gr_no = '$gr_no'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0)
		{
			$titleArr = mysqli_fetch_assoc($result);
			$title = $titleArr['name'];
			mysqli_free_result($result);
			//echo $title;
			$sql = "SELECT pname,contact_no,email from publisher where pub_id in (select pub_id from book where gr_no = '$gr_no')";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				$pubArr = mysqli_fetch_assoc($result);
				//print_r($pubArr);
				$publisher = $pubArr['pname'];
				$publisher_contact = $pubArr['contact_no'];
				$publisher_email = $pubArr['email'];
			}
			mysqli_free_result($result);
			$sql = "SELECT first_name,last_name from author where auth_id in (select auth_id from book_author where gr_no = '$gr_no')";
			$result = mysqli_query($conn, $sql);
			$authArr = mysqli_fetch_all($result);
			//print_r($authArr);
			foreach ($authArr as $auth)
			{
				$author = $author . $auth[0] . " " . $auth[1] . ", ";
			}
			mysqli_free_result($result);
			$sql = "SELECT category from book where gr_no = '$gr_no'";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				$catArr = mysqli_fetch_assoc($result);
				//print_r($pubArr);
				$category = $catArr['category'];
			}
			mysqli_free_result($result);
			$sql = "SELECT shelf,section,floor from location where loc_id in (SELECT loc_id from book where gr_no = '$gr_no')";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				$locArr = mysqli_fetch_assoc($result);
				//print_r($pubArr);
				$shelf = $locArr['shelf'];
				$section = $locArr['section'];
				$floor = $locArr['floor'];
			}
			mysqli_free_result($result);
			$disableInput = true;
		}
		else
		{
			$error = "No such GR Number disableInput";
		}
	}
	if(isset($_GET['title_search']))
	{
		$title = mysqli_real_escape_string($conn,$_GET['title']);
		$sql = "select gr_no,name from book where name like '%$title%'";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0)
		{
			$titleArr = mysqli_fetch_assoc($result);
			$title = $titleArr['name'];
			$gr_no = $titleArr['gr_no'];
			//echo $title;
			mysqli_free_result($result);
			$sql = "SELECT pname,contact_no,email from publisher where pub_id in (select pub_id from book where gr_no = '$gr_no')";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				$pubArr = mysqli_fetch_assoc($result);
				//print_r($pubArr);
				$publisher = $pubArr['pname'];
				$publisher_contact = $pubArr['contact_no'];
				$publisher_email = $pubArr['email'];
			}
			mysqli_free_result($result);
			$sql = "SELECT first_name,last_name from author where auth_id in (select auth_id from book_author where gr_no = '$gr_no')";
			$result = mysqli_query($conn, $sql);
			$authArr = mysqli_fetch_all($result);
			//print_r($authArr);
			foreach ($authArr as $auth)
			{
				$author = $author . $auth[0] . " " . $auth[1] . ", ";
			}
			mysqli_free_result($result);
			$sql = "SELECT category from book where gr_no = '$gr_no'";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				$catArr = mysqli_fetch_assoc($result);
				//print_r($pubArr);
				$category = $catArr['category'];
			}
			mysqli_free_result($result);
			$sql = "SELECT shelf,section,floor from location where loc_id in (SELECT loc_id from book where gr_no = '$gr_no')";
			$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{
				$locArr = mysqli_fetch_assoc($result);
				//print_r($pubArr);
				$shelf = $locArr['shelf'];
				$section = $locArr['section'];
				$floor = $locArr['floor'];
			}
			mysqli_free_result($result);
			$disableInput = true;
		}
		else
		{
			$error = "No such Book Exists";
		}
	}
	if(isset($_GET['add']))
	{
		if($_GET['disabled'])
		{
			if(isset($_GET['gr_no'])&&$_GET['gr_no']!=''
				&&isset($_GET['edition'])&&$_GET['edition']!=''
				&&isset($_GET['mrp'])&&$_GET['mrp']!=''
				&&isset($_GET['price'])&&$_GET['price']!=''
				&&isset($_GET['gifted_bought'])&&$_GET['gifted_bought']!=''
				&&isset($_GET['copies'])&&$_GET['copies']!='')
			{
				$gr_no = mysqli_real_escape_string($conn, $_GET['gr_no']);
				$edition = mysqli_real_escape_string($conn, $_GET['edition']);
				$mrp = mysqli_real_escape_string($conn, $_GET['mrp']);
				$price = mysqli_real_escape_string($conn, $_GET['price']);
				if(isset($_GET['gifted_bought']))
				{
					$gifted_bought = mysqli_real_escape_string($conn, $_GET['gifted_bought']);
					if($gifted_bought=='G')
						$gifted_bought = 0;
					else
						$gifted_bought = 1;
				}
				$copies = mysqli_real_escape_string($conn, $_GET['copies']);
				$sql = "select count(*) from copy where gr_no = '$gr_no'";
				$result = mysqli_query($conn, $sql);
				$copyNos = mysqli_fetch_assoc($result);
				$copyNo = $copyNos['count(*)'];
				mysqli_free_result($result);
				$copyNo++;
				for($i = 1; $i<=$copies; $i++)
				{
					$sql = "INSERT into copy values('$gr_no', $copyNo ,1,";
						if($edition!='')
							$sql = $sql.$edition . ",";
						else
							$sql = $sql."NULL,";
						if($mrp!='')
							$sql = $sql.$mrp . ",";
						else
							$sql = $sql."NULL,";
						if($price!='')
							$sql = $sql.$price . ",";
						else
							$sql = $sql."NULL,";
						if($gifted_bought!='')
							$sql = $sql.$gifted_bought;
						else
							$sql = $sql."NULL";
						$sql = $sql . ", 1)";
					if (mysqli_query($conn, $sql)) {
					  	//echo "values inserted into copy table<br />";
					} else {
					 	 echo "error instering values: Please contact administration " . mysqli_error($conn) . "<br />";
					}
					//echo $sql;
					//echo "<br>";
					$copyNo++;
				}
				//echo $copies+3;
				//echo $sql;
				echo "<center>BOOKS ADDED </center><br>";
				$title='';
				$gr_no='';
				$error = '';
				$publisher='';
				$publisher_contact = '';
				$publisher_email = '';
				$author = '';
				$shelf = '';
				$section = '';
				$floor = '';
				$category = '';
				$disableInput = false;
				$problem = false;
			}
			else
			{
				$error = "Please fill all columns properly";
				echo $error;
			}
		}
		else
		{
			if(isset($_GET['gr_no'])&&$_GET['gr_no']!=''
				&&isset($_GET['title'])&&$_GET['title']!=''
				&&isset($_GET['publisher'])&&$_GET['publisher']!=''
				&&isset($_GET['author'])&&$_GET['author']!=''
				&&isset($_GET['category'])&&$_GET['category']!=''
				&&isset($_GET['copies'])&&$_GET['copies']!='')
			{
				$gr_no = mysqli_real_escape_string($conn, $_GET['gr_no']);
				$title = mysqli_real_escape_string($conn, $_GET['title']);
				$publisher = mysqli_real_escape_string($conn, $_GET['publisher']);
				$author = mysqli_real_escape_string($conn, $_GET['author']);
				$category = mysqli_real_escape_string($conn, $_GET['category']);
				$copies = mysqli_real_escape_string($conn, $_GET['copies']);
				$publisher_contact ='';
				$publisher_email = '';
				$edition = '';
				$mrp = '';
				$price = '';
				if(isset($_GET['publisher_email']))
					$publisher_email = mysqli_real_escape_string($conn, $_GET['publisher_email']);
				if(isset($_GET['publisher_contact']))
					$publisher_contact = mysqli_real_escape_string($conn, $_GET['publisher_contact']);
				if(isset($_GET['edition']))
					$edition = mysqli_real_escape_string($conn, $_GET['edition']);
				if(isset($_GET['mrp']))
					$mrp = mysqli_real_escape_string($conn, $_GET['mrp']);
				if(isset($_GET['price']))
					$price = mysqli_real_escape_string($conn, $_GET['price']);
				if(isset($_GET['gifted_bought']))
				{
					$gifted_bought = mysqli_real_escape_string($conn, $_GET['gifted_bought']);
					if($gifted_bought=='G')
						$gifted_bought = 0;
					else
						$gifted_bought = 1;
				}
				if(isset($_GET['shelf']))
					$shelf = mysqli_real_escape_string($conn, $_GET['shelf']);
				if(isset($_GET['section']))
					$section = mysqli_real_escape_string($conn, $_GET['section']);
				if(isset($_GET['floor']))
					$floor = mysqli_real_escape_string($conn, $_GET['floor']);
				// $publisher_contact;
				$sql = "SELECT loc_id from location where";
				if($shelf=='')
			  		$sql = $sql. " shelf is NULL and";
			  	else
			  		$sql = $sql. " shelf = $shelf and";
			  	if($section=='')
			  		$sql = $sql. " section is NULL and";
			  	else
			  		$sql = $sql. " section = $section and";
			  	if($floor =='')
			  		$sql = $sql. " floor is NULL";
			  	else
			  		$sql = $sql. " floor = $floor";
				
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0)
				{
				  	$loc_idArr = mysqli_fetch_assoc($result);
					mysqli_free_result($result);
					$loc_id = $loc_idArr['loc_id'];
				}
				else 
				{
				  	mysqli_free_result($result);
				  	if($shelf=='')
				  		$shelf = "NULL";				
				  	if($section=='')
				  		$section = "NULL";
				  	if($floor =='')
				  		$floor = "NULL";
				  	$sql = "Insert into location(shelf,section,floor) values($shelf,$section,$floor)";
				  	// echo $sql;
			  		// echo "<br>";
				  	if (mysqli_query($conn, $sql))
				  	{
				  		//echo 'ValueInserted';
				  		$sql = "SELECT loc_id from location where";
				  		if($shelf=="NULL")
					  		$sql = $sql. " shelf is NULL and";
					  	else
					  		$sql = $sql. " shelf = $shelf and";
					  	if($section=="NULL")
					  		$sql = $sql. " section is NULL and";
					  	else
					  		$sql = $sql. " section = $section and";
					  	if($floor=="NULL")
					  		$sql = $sql. " floor is NULL";
					  	else
					  		$sql = $sql. " floor = $floor";
					  	// echo $sql;
					  	// echo "<br>";
						$result = mysqli_query($conn, $sql);
						$loc_idArr = mysqli_fetch_assoc($result);
						mysqli_free_result($result);
						$loc_id = $loc_idArr['loc_id'];
				  	}
				  	else
				  	{
				  		echo 'Problem in inserting values please contact library staff eerr' . mysqli_error($conn) . "<br />";
				  		$problem = true;
				  	}
				}
				$sql = "SELECT pub_id from publisher where pname='$publisher'";
				$result = mysqli_query($conn, $sql);
				if (mysqli_num_rows($result) > 0)
				{
				  	$pub_idArr = mysqli_fetch_assoc($result);
					mysqli_free_result($result);
					$pub_id = $pub_idArr['pub_id'];
				}
				else
				{
					mysqli_free_result($result);
				  	$sql = "Insert into publisher(pname,contact_no,email) values('$publisher',";
				  	if($publisher_contact=='')
				  		$sql = $sql . "NULL,";
				  	else
				  		$sql = $sql . "'$publisher_contact',";
				  	if($publisher_email=='')
				  		$sql = $sql . "NULL);";
				  	else
				  		$sql = $sql . "'$publisher_email');";
				  	// echo $sql;
				  	// echo "<br>";
				  	if (mysqli_query($conn, $sql))
				  	{
				  		//echo 'ValueInserted';
				  		$sql = "SELECT pub_id from publisher where pname='$publisher'";
						$result = mysqli_query($conn, $sql);
						$pub_idArr = mysqli_fetch_assoc($result);
						mysqli_free_result($result);
						$pub_id = $pub_idArr['pub_id'];
				  	}
				  	else
				  	{
				  		echo 'Problem in inserting values please contact library staff sdgsgsg' . mysqli_error($conn) . "<br />";
				  		$problem = true;
				  	}
				}

				if(!$problem)
				{
					$sql = "INSERT into book values('$gr_no', '$title', '$category', 0, $pub_id, $loc_id)";
					//echo $sql;
					if (mysqli_query($conn, $sql))
					{
						//echo "book created <br />";
					} else 
					{
					  	echo "error creating book, please contact library staff" . mysqli_error($conn) . "<br />";
					}
					for($i = 1; $i<=$copies; $i++)
					{
						$sql = "INSERT into copy values('$gr_no', $i ,1,";
						if($edition!='')
							$sql = $sql.$edition . ",";
						else
							$sql = $sql."NULL,";
						if($mrp!='')
							$sql = $sql.$mrp . ",";
						else
							$sql = $sql."NULL,";
						if($price!='')
							$sql = $sql.$price . ",";
						else
							$sql = $sql."NULL,";
						if($gifted_bought!='')
							$sql = $sql.$gifted_bought;
						else
							$sql = $sql."NULL";
						$sql = $sql . ", 1)";
						//$sql = "Insert into copy values('$gr_no', $i, 1, $edition, $mrp, $price, $gifted_bought, 1)";
						if (mysqli_query($conn, $sql)) {
					  		//echo "values inserted into copy table<br />";
						} 
						else {
						 	 echo "error instering values: Please contact administration " . mysqli_error($conn) . "<br />";
						}
						//echo $sql;
						//echo "<br>";
					}
					$authors = explode(',', $author);
					// print_r($authors);
					// echo "<br>";
					foreach ($authors as $author)
					{
						// echo "$author";
						// echo "<br>";
						$sql = "select auth_id from author where first_name like '%$author%'";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0)
						{
							$auth_idArr = mysqli_fetch_assoc($result);
							mysqli_free_result($result);
							$auth_id = $auth_idArr['auth_id'];
							//echo "$gr_no,$auth_id";
							//echo "ee<br>";
							$sql = "INSERT into book_author values('$gr_no', $auth_id)";
							if(mysqli_query($conn, $sql)) {
							  	//echo "values inserted <br />";
							} else {
							  	echo "error instering values: please contact administrator" . mysqli_error($conn) . "<br />";
							}
						}
						else
						{
							mysqli_free_result($result);
							$sql = "Insert into author(first_name,last_name) values ('$author','')";
							if(mysqli_query($conn, $sql))
							{
							  	//echo "values inserted <br />";
							  	$sql = "select auth_id from author where first_name like '%$author%'";
								$result = mysqli_query($conn, $sql);
								if (mysqli_num_rows($result) > 0)
								{
									$auth_idArr = mysqli_fetch_assoc($result);
									mysqli_free_result($result);
									$auth_id = $auth_idArr['auth_id'];
									//echo "$gr_no,$auth_id";
									//echo "ee<br>";
									$sql = "INSERT into book_author values('$gr_no', $auth_id)";
									if(mysqli_query($conn, $sql)) {
									  	//echo "values inserted <br />";
									} else {
									  	echo "error instering values: please contact administrator" . mysqli_error($conn) . "<br />";
									}
								}
							} else {
							  	echo "error inserting values: please contact administrator" . mysqli_error($conn) . "<br />";
							}
						}
						//echo "<br>ferr";
						
					}
					echo "<center>BOOKS ADDED </center><br>";
					$title='';
					$gr_no='';
					$error = '';
					$publisher='';
					$publisher_contact = '';
					$publisher_email = '';
					$author = '';
					$shelf = '';
					$section = '';
					$floor = '';
					$category = '';
					$disableInput = false;
					$problem = false;
				}
				else
				{
					echo 'There is some problem, Please contact administrator';
				}
			}
			else
				echo 'Please fill all required columns';
		}

	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Add new book</title>
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
<div style="padding-left:1%;padding-right:3%;padding-top:2%;" class = "text-center">
<form action="addNewBook.php" method="GET">
		<table class="table table-borderless table-sm">
			<form action="addNewCopy.php" method="GET">
				<tr >
					<th width ="20%">Book GR number</th>
						<td>
							<div class = "textbox">
					 			<input type = "text" class="form-control" name = "gr_no" value="<?php echo "$gr_no"; ?>" >
							</div>
						</td>
						<td>
							<input type="Submit" class='btn btn-sm btn-info' name="gr_search" class = "buttons" value="Search">
						</td>
				</tr>
				<tr>	
					<th>Book Title*</th>
					<td>
						<div class = "textbox">
				 			<input type = "text" class="form-control" name = "title" value="<?php echo "$title"; ?>">
				 		</div>
				 	</td>
				 	<td>
						<input type="Submit" class="btn btn-sm btn-info" name="title_search" class = "buttons" value="Search">
					</td>
				</tr>
			</form>
			<tr>
				<th>Publisher*</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control" name = "publisher" value="<?php echo "$publisher"; ?>"
			 			<?php echo $disableInput ? "disabled" : '' ;?>>
			 		</div>
			 	</td>
			</tr>
			<tr>
				<th>Publisher Contact</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control"  name = "publisher_contact" value="<?php echo "$publisher_contact"; ?>"
			 			<?php echo $disableInput ? "disabled" : '' ;?>>
			 		</div>
			 	</td>
			</tr>
			<tr>
				<th>Publisher Email</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control"  name = "publisher_email" value="<?php echo "$publisher_email"; ?>"
			 			<?php echo $disableInput ? "disabled" : '' ;?>>
			 		</div>
			 	</td>
			</tr>
			<tr>
				<th>Author*</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control"  name = "author" value="<?php echo "$author"; ?>"
			 			<?php echo $disableInput ? "disabled" : '' ;?>>
			 		</div>
			 	</td>
			 	<td>Please input all authors seperated by commas(,)</td>
			</tr>
			<tr>
				<th>Edition</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control"  name = "edition" >
			 		</div>
			 	</td>
			</tr>
			<tr>
				<th>MRP</th>
			    <td>
			    	<div class = "textbox">
			 			<input type = "text" class="form-control" name = "mrp" >
			 		</div>
			 	</td>
			</tr>
			<tr>
				<th>Actual Price</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control" name = "price" >
			 		</div>
			 	</td>
			</tr>
			<tr>
				<th> Gifted/Bought </th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control" name = "gifted_bought" >
			 		</div>
			 	</td>
			 	<td>Please write G for gifted and B for bought</td>
				</tr>
	        <tr>
				<th>No. of copies*</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control" name = "copies" >
			 		</div>
			 	</td>
			 </tr>
			<tr>
				<th>Genre*</th>
				<td>
					<div class = "textbox">
			 			<input type = "text" class="form-control" name = "category" value="<?php echo "$category"; ?>"
			 			<?php echo $disableInput ? "disabled" : '' ;?>>
			 		</div>
			 	</td>
			 </tr>	

			<tr>
				<th>Shelf</th>
				<td>
					<div class = "textbox">
		 				<input type = "text" class="form-control" name = "shelf" value="<?php echo "$shelf"; ?>"
		 				<?php echo $disableInput ? "disabled" : '' ;?>>
		 			</div>
		 		</td>
			 </tr>

			<tr>
				<th>Section</th>
				<td>
					<div class = "textbox">
						<input type = "text" class="form-control" name = "section" value="<?php echo "$section"; ?>"
						<?php echo $disableInput ? "disabled" : '' ;?>>
		 			</div>
		 		</td>
			</tr>

			<tr>
				<th>Floor</th>
				<td>
					<div class = "textbox">
						<input type = "text" class="form-control" name = "floor" value="<?php echo "$floor"; ?>"
						<?php echo $disableInput ? "disabled" : '' ;?>>
		 			</div>
		 		</td>
			</tr>
	        <tr>
	        	<input type="hidden" name="disabled" value = "<?php echo $disableInput ? '1':'0' ; ?>">
				<th><input type="submit" class="btn btn-lg btn-primary" name="add" class="buttons" value="Submit"></th>
			</tr>

		</table>
	</form>
</div>
	
</body>