<?php
	include('../config/connectDB.php');
	$search_book_name = '';
	$error = '';
	$flag=0;
	$search_by="";
    $data="";
    $sql="";
    $sql1="";
    $books1=array();
    $books2=array();
	$availableBooks = true;
	$notavailableBooks=true;
	$sql01 = "SELECT book.gr_no,name,rating,category,status from book,copy where book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no";
    $result01 = mysqli_query($conn, $sql01);
			if(mysqli_num_rows($result01) > 0)
			{
				$books1 = mysqli_fetch_all($result01);
			}
			else
			{
				$availableBooks = false;
			}
			mysqli_free_result($result01);
 
    $sql02 = "SELECT book.gr_no,name,rating,category,status from book,copy where  book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
     


	$result = mysqli_query($conn, $sql02);
	if(mysqli_num_rows($result) > 0)
	{
		$books2 = mysqli_fetch_all($result);
	}
	else
	{
		$notavailableBooks = false;	
	}
	mysqli_free_result($result);
    






     $flipped_get = array_flip($_GET);
	
	if(isset($flipped_get['checkout reviews']))
	{
		//echo $flipped_get['Remove'];
		$my_gr_no = mysqli_real_escape_string($conn, $flipped_get['checkout reviews']);
                session_start();
                $_SESSION["my_gr_no"] = $my_gr_no;
                header('Location: ShowReview.php');
  }




   if(isset($_POST['gr_button']))
	{
		$gr_num = mysqli_real_escape_string($conn, $_POST['gr_button']);
		session_start();
		$_SESSION["gr_no"] = $gr_num;
		header('Location: BookDetails.php');
	}


   if(isset($_POST['search_book']))
{ 
	if(isset($_POST['search_on']))
	{
		$search_by = mysqli_real_escape_string($conn, $_POST['search_on']);
		$data= mysqli_real_escape_string($conn, $_POST['data']);
		
	}
   else
   { $flag=1;
   }

  
   if($search_by=="name")
   {
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no";


    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where name like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";

   }
   if($search_by=="genre")
   {  
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where category like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no";

    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy where category like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where category like '%$data%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
   
   }
   if($search_by=="rating")
   {if(is_numeric($data))
   	{
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where rating=$data AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no";


     $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy where rating=$data AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where rating=$data AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
   } 
}

  if($search_by=="auth1")
   {  
    $sql = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where  a.first_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and   copy.conditions=1 AND copy.status = 1 group by book.gr_no";

    $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where a.first_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and  copy.conditions=1 AND copy.status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy,book_author ba,author a where a.first_name like '%$data%' AND book.gr_no = copy.gr_no AND  book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and copy.conditions=1 AND copy.status = 1 group by book.gr_no) group by book.gr_no";
   
   }

  // if($search_by=="auth2")
  //  {  
  //   $sql = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where  a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and   copy.conditions=1 AND status = 1 group by book.gr_no";

  //   $sql1 = "SELECT book.gr_no,name,rating,category,status from book,copy,book_author ba,author a where a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and  copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy,book_author ba,author a where a.last_name like '%$data%' AND book.gr_no = copy.gr_no AND  book.gr_no=ba.gr_no and a.auth_id=ba.auth_id and copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
   
  //  }


   
   if($sql!="")
    {		$result = mysqli_query($conn, $sql);
			if(mysqli_num_rows($result) > 0)
			{   $availableBooks = true;
				$books1 = mysqli_fetch_all($result);
			}
			else
			{
				$availableBooks = false;
			}
			mysqli_free_result($result);
   }
   else
   {
   	$availableBooks = false;
    
   }

    if($sql1!="")
    {
    $result = mysqli_query($conn, $sql1);
	if(mysqli_num_rows($result) > 0)
	{      $notavailableBooks = true;	
		$books2 = mysqli_fetch_all($result);
	}
	else
	{
		$notavailableBooks = false;	
	}
	mysqli_free_result($result);
  }
  else
  {
   $notavailableBooks = false;	
  }

	if(!$availableBooks && !$notavailableBooks)
	{   
		$error = "NA";
	}



}










































	// if(isset($_GET['search_book']))
	// {
	// 	$search_book_name = mysqli_real_escape_string($conn, $_GET['search_book']);
	// }
	//else
	// {
	// 	$search_book_name = '';
	// }
	// $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$search_book_name%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no";
	// $result = mysqli_query($conn, $sql);
	// if(mysqli_num_rows($result) > 0)
	// {
	// 	$books1 = mysqli_fetch_all($result);
	// }
	// else
	// {
	// 	$availableBooks = false;
	// }
	// mysqli_free_result($result);
	// $sql = "SELECT book.gr_no,name,rating,category,status from book,copy where name like '%$search_book_name%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 0 and book.gr_no not in (SELECT book.gr_no from book,copy where name like '%$search_book_name%' AND book.gr_no = copy.gr_no AND copy.conditions=1 AND status = 1 group by book.gr_no) group by book.gr_no";
	// $result = mysqli_query($conn, $sql);
	// if(mysqli_num_rows($result) > 0)
	// {
	// 	$books2 = mysqli_fetch_all($result);
	// }
	// else
	// {
	// 	$notavailableBooks = false;	
	// }
	// mysqli_free_result($result);
	// if(!$availableBooks && !$notavailableBooks)
	// {
	// 	$error = "No Such book exists";
	// }

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
<!-- Navbar -->
<form action="BookSearchPage.php" method="POST">
<div class="container" style="margin-top:40px">
  <input class="form-control" id="anythingSearch" type="text" name="data" placeholder="Type something to search list items">
  <div id="myDIV" style="margin-top:20px">
    <button class="btn btn-primary" type="submit" name="search_book">Search</button>
    <button class="btn btn-info" type="submit" name="">Clear</button>
  </div>
  <div class="form-check form-check-inline" style="margin-top:20px">
  <input class="form-check-input" type="radio" id="name" name="search_on" value="name" />
  <label class="form-check-label" for="inlineRadio1">By Book Name</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="genre" name="search_on" value="genre" />
  <label class="form-check-label" for="inlineRadio2">By Genre</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="rating" name="search_on" value="rating" />
  <label class="form-check-label" for="inlineRadio3">By Rating</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="auth1" name="search_on" value="auth1" />
  <label class="form-check-label" for="inlineRadio3">By Author Name</label>
</div>
</div>
<div style="padding-left:7%;padding-right:7%;padding-top:20px;">
</form>
<table class="table table-striped table-responsive-md btn-table">

<thead>
  <tr>
    <th>Book ID</th>
    <th>Book Name</th>
    <th>Rating</th>
    <th>Genre</th>
	<th>Author</th>
	<th>Availability</th>
	<th>Reviews</th>
  </tr>
</thead>
<?php
					if($availableBooks):
						foreach($books1 as $book):
				?>
						<tr>
	                     <form action="BooksearchPage.php" method="POST">
	      					<td>
							  <button type="submit"name="gr_button" class="btn btn-default btn-dark btn-sm"><?php echo $book[0]; ?></button>
	      					</td>
	                    	</form>	
				
                    	<?php
                      //  
						// echo "<td>". $book[0]."</td>";
						echo "<td>". $book[1] ."</td>";
						echo "<td>". $book[2] ."</td>";
						echo "<td>". $book[3]." </td>";
						 
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
             <form action="BooksearchPage.php" method="GET">
				  	<td>
      				<input type="submit" name="<?php echo $book[0]; ?>" class = "buttons" value="checkout reviews" > 
      			</td>
      			</form>


						</tr>
				<?php
						endforeach;
					endif;
					if($notavailableBooks):
						foreach($books2 as $book):
				?>
						<tr>

							<form action="BooksearchPage.php" method="POST">
      					<td>
						  <button type="submit"name="gr_button" class="btn btn-default btn-dark btn-sm"><?php echo $book[0]; ?></button>
      					</td>
                    		</form>

				<?php
						// echo "<td>". $book[0]."</td>";
						echo "<td>". $book[1] ."</td>";
						echo "<td>". $book[2] ."</td>";
						echo "<td>". $book[3]." </td>";
						
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
              <form action="BooksearchPage.php" method="GET">
				 <td>
      				<input type="submit" name="<?php echo $book[0]; ?>" class = "buttons" value="checkout reviews" > 
      			</td>
      		</form>


						</tr>
				<?php
						endforeach;
					endif;
					if($flag==1):
		               echo "<tr><td colspan=\"7\">"."please select the search criteria  "."</td></tr>";
					
					elseif(!$availableBooks&&!$notavailableBooks):
						echo "<tr><td colspan=\"7\">".$error."</td></tr>";
					endif;
				?>
			</tr>
<!-- <tbody>
  <tr>
    <th scope="row">1</th>
    <td>
      <button type="button" class="btn btn-primary btn-sm m-0">Yes</button>
	  <button type="button" class="btn btn-indigo btn-sm m-0">No</button>
    </td>
    <td>Otto</td>
    <td>@mdo</td>
  </tr>
  <tr>
    <th scope="row">2</th>
    <td>Jacob</td>
    <td>
      <button type="button" class="btn btn-indigo btn-sm m-0">Button</button>
    </td>
    <td>@fat</td>
  </tr>
  <tr>
    <th scope="row">3</th>
    <td>Larry</td>
    <td>the Bird</td>
    <td>
      <button type="button" class="btn btn-indigo btn-sm m-0">Button</button>
    </td>
  </tr>
</tbody>

</table> 
</div>   -->
</body>