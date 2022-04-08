<?php
	session_start();
	$college_id = $_SESSION['college_id'];
	

	include('../config/connectDB.php');
      $today;
	  $sql1 = "SELECT CURRENT_DATE AS Date ";
	$result = mysqli_query($conn, $sql1);
	$inf = mysqli_fetch_assoc($result);
	$today = $inf['Date'];
	mysqli_free_result($result);

    $sql01 = "SELECT due_date from record,member where record.due_date < '$today' and record.issued_by=member.mem_id and member.college_id='$college_id'and return_date is NULL ";
    $amt =0;
    $result01 = mysqli_query($conn, $sql01);
			if(mysqli_num_rows($result01) > 0)
			{
				$finerecord = mysqli_fetch_all($result01);
				foreach($finerecord as $fine):
					$d1 = new DateTime($today);
                    $d2 = new DateTime($fine[0]);
                    $d  = $d1->diff($d2)->format('%a');

					$amt=$amt+(10*$d );
					
				endforeach;
					
          }

     $sql22 = "UPDATE member set fine_due='$amt' where college_id='$college_id' ";
	    mysqli_query($conn, $sql22);
	    


	$sql = "SELECT designation FROM member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql);
	$homeButtons = array();
	if(mysqli_num_rows($result) > 0)
	{
		$designation = mysqli_fetch_assoc($result);
		if($designation['designation']==='student'||$designation['designation']==='teacher'||$designation['designation']==='non_teacher')
		{
			$homeButtons = [
							['Search Books','BookSearchPage.php'],
							['My Profile','userhomepage.php'],
							['My History','History.php'],
							['Book Recommender','Recommender.php'],
							['Change Password','ChangePassword.php']
							];
		}
		else
		{
			$homeButtons = [
								['Search Books','BookSearchPage.php'],
								['My Profile','userhomepage.php'],
								['My History','History.php'],
								['Book Recommender','Recommender.php'],
								['Return Book','Return.php'],
								['Pending Requests','Requests.php'],
								['Search Student','SearchStudent.php'],
								['Add a new Book','addNewBook.php'],
								['Change Password','ChangePassword.php']
								];
		}
		//print_r($homeButtons);
	}
	else
	{
		$error = "Error, please login again";
		header('Location: ../index.php');
	}
	$today;
	  $sql1 = "SELECT CURRENT_DATE AS Date ";
	$result = mysqli_query($conn, $sql1);
	$inf = mysqli_fetch_assoc($result);
	$today = $inf['Date'];
	mysqli_free_result($result);

    $sql01 = "SELECT due_date from record,member where record.due_date < '$today' and record.issued_by=member.mem_id and member.college_id='$college_id'and return_date is NULL ";
    $amt =0;
    $result01 = mysqli_query($conn, $sql01);
			if(mysqli_num_rows($result01) > 0)
			{
				$finerecord = mysqli_fetch_all($result01);
				foreach($finerecord as $fine):
					$d1 = new DateTime($today);
                    $d2 = new DateTime($fine[0]);
                    $d  = $d1->diff($d2)->format('%a');

					$amt=$amt+(10*$d );
					
				endforeach;
					
          }

     $sql22 = "UPDATE member set fine_due='$amt' where college_id='$college_id' ";
	    mysqli_query($conn, $sql22);


	 $sql = "SELECT name,college_id,password,designation,phone,email,fine_due from member 
	 where college_id='$college_id' ";
	$result = mysqli_query($conn, $sql);

	$recordinfo=mysqli_fetch_row($result);
	mysqli_free_result($result);
	mysqli_close($conn);
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	
		<title>Sign Up Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
          <a class="nav-link" href ="../index.php">Logout</a>
        </li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
            Options
          </a>
          <!-- Dropdown menu -->
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
		  <?php
				for($i=0;$i<count($homeButtons);$i++):
			?>
            <li>
              <a class="dropdown-item" href="<?php echo $homeButtons[$i][1]; ?>"><?php echo $homeButtons[$i][0]; ?></a>
            </li>
			<?php endfor; ?>
          </ul>
        </li>

      </ul>

    </div>
  </div>
  <!-- Container wrapper -->
</nav>
<section style="background-color: #eee;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="../images/av3.jpg" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?php echo $recordinfo[0]?></h5>
            <p class="text-muted mb-1"><?php echo $recordinfo[3]?></p>
            <p class="text-muted mb-4">Birla Institue of Technology and Sciences, Pilani</p>
          </div>
        </div>
        <div class="card mb-4 mb-lg-0">
          <div class="card-body p-0">
            
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $recordinfo[0]?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">College ID</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $recordinfo[1]?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Phone</p>
				</div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $recordinfo[4]?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Designation</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $recordinfo[3]?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0"><?php echo $recordinfo[5]?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Amount Due</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">₹ <?php echo $recordinfo[6]?></p>
              </div>
            </div>
          </div>
        </div>
       
    </div>
  </div>
</section>
</body>