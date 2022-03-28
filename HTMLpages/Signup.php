<?php 
	include('../config/connectDB.php');
	$error = '';
	$name = '';
	$college_id = '';
	$email = '';
	$contact = '';
	$new_password = '';
	$retype_password = '';
	$designation = '';
	if(isset($_POST['register']))
	{
		if(isset($_POST['name'])&&isset($_POST['college_id']) && isset($_POST['email']) && isset($_POST['contact']) && isset($_POST['new_password']) && isset($_POST['retype_password']) && isset($_POST['designation']))
		{
			$name = mysqli_real_escape_string($conn, $_POST['name']);
			$college_id = mysqli_real_escape_string($conn, $_POST['college_id']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$contact = mysqli_real_escape_string($conn, $_POST['contact']);
			$new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
			$retype_password = mysqli_real_escape_string($conn, $_POST['retype_password']);
			$designation = mysqli_real_escape_string($conn, $_POST['designation']);
			if(!($new_password===$retype_password))
			{
				$error = "Both passwords Don't match";
			}
			else
			{
				if(!preg_match('/^20[0-9]{2}[A-Z0-9]{2}PS[0-9]{4}H$/',$college_id))
					$error = 'wrong college id';
				if(!filter_var($email,FILTER_VALIDATE_EMAIL))
					$error = "Email id is in incorrect format";
				if(!preg_match('/^[0-9]{10}$/', $contact))
					$error = "Wrong phone number";
				if($error=='')
				{
					$sql = "SELECT college_id,email,phone from member where college_id = '$college_id'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)==0)
					{
						mysqli_free_result($result);
						$sql = "SELECT college_id,email,phone from member where email = '$email'";
						$result = mysqli_query($conn, $sql);
						if(mysqli_num_rows($result)==0)
						{
							mysqli_free_result($result);
							$sql = "SELECT college_id,email,phone from member where phone = '$contact'";
							$result = mysqli_query($conn, $sql);
							if(mysqli_num_rows($result)==0)
							{
								mysqli_free_result($result);
								$sql = "insert into member(name,phone,email,designation,fine_due,college_id,password,verification_status) values('$name','$contact','$email','$designation',0,'$college_id','$new_password',0)";
								if (mysqli_query($conn, $sql)) {
								  	header('Location: ../index.php');
								} else {
								  	echo "error instering values: " . mysqli_error($conn) . "<br />";
								}
								//echo $sql;
							}
							else
								$error = 'phone number already in use';
						}
						else
							$error = 'Email id already in use';
						
					}
					else
					{
						$error = "User has already registered";
					}
					
				}				
			}
		}
		else
		{
			$error = 'Please Fill all Fields';
		}
		//echo "$error <br>";
		//echo "$name $college_id $email $contact $new_password $retype_password $designation <br>";
	}
	

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

                <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ExpressRead</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Back</a>
        </li>
      </ul>
    </div>
  </div>
</nav> -->
		<!-- <form action="Signup.php" method = "POST">
		<table style= "margin-left: 20%">
			<tr>
				<td>Name</td>
				<td><div class = "textbox">
					 	<input type = "text"  name = "name" value = "<?php echo htmlspecialchars($name);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>College ID</td>
				<td><div class = "textbox">
					 	<input type = "text"  name = "college_id" value = "<?php echo htmlspecialchars($college_id);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>Email id</td>
				<td>
					<div class = "textbox">
					 	<input type = "text"  name = "email"  value = "<?php echo htmlspecialchars($email);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>Contact no.</td>
				<td>
					<div class = "textbox">
					 	<input type = "text" name = "contact"  value = "<?php echo htmlspecialchars($contact);?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>Set Password</td>
				<td>
					<div class = "textbox">
					 	<input type = "password"  name = "new_password">
					</div>
				</td>
			</tr>
			<tr>
				<td>Retype Password</td>
				<td>
					<div class = "textbox">
					 	<input type = "password"  name = "retype_password">
					</div>
				</td>
			</tr>
			<tr>
				<td>Designation</td>
				<td>
					<div class = "textbox">
					 	<input type="radio" id="student" name="designation" value="student">
							<label for="student">Student</label>
						<input type="radio" id="teacher" name="designation" value="teacher">
							<label for="teacher">Teacher</label>
						<input type="radio" id="non_teacher" name="designation" value="non_teacher">
							<label for="non_teacher">Non Teacher</label>
						<input type="radio" id="admin" name="designation" value="admin">
							<label for="admin">Admin</label>
					</div>
				</td>
			</tr>
			<tr>
				<td> <input type="submit" name="register" class = "buttons" value="Register"></td>
			</tr>
			<tr>
				<td><div class="red_text"><?php echo htmlspecialchars($error);?></td>
			</tr>
		</table>

	</form> -->
    <section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                <form class="mx-1 mx-md-4" action="Signup.php" method = "POST">

                  <div class="d-flex flex-row align-items-center mb-2">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" name="name" id="form3Example1c" class="form-control" value = "<?php echo htmlspecialchars($name);?>" />
                      <label class="form-label" for="form3Example1c">Your Name</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-2">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="email" name="email" id="form3Example3c" class="form-control"  value = "<?php echo htmlspecialchars($email);?>"/>
                      <label class="form-label" for="form3Example3c">Your Email</label>
                    </div>
                  </div>
                  <div class="d-flex flex-row align-items-center mb-2">
                    <i class="fas fa-university fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" name="college_id" id="form3Example3c" class="form-control"  value = "<?php echo htmlspecialchars($college_id);?>"/>
                      <label class="form-label" for="form3Example3c">Your College ID</label>
                    </div>
                  </div>
                  <div class="d-flex flex-row align-items-center mb-2">
                    <i class="fas fa-mobile fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" name="contact" id="form3Example3c" class="form-control" value = "<?php echo htmlspecialchars($contact);?>"/>
                      <label class="form-label" for="form3Example3c">Your Phone</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-2">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" name = "new_password" id="form3Example4c" class="form-control" name="new_passwrod"/>
                      <label class="form-label" for="form3Example4c">Password</label>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-2">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="form3Example4cd" name="retype_password" class="form-control" name = "retype_password"/>
                      <label class="form-label" for="form3Example4cd">Repeat your password</label>
                    </div>
                  </div>
                  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio"  id="student" name="designation" value="student" />
  <label class="form-check-label" for="inlineRadio1">Student</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" id="teacher" name="designation" value="teacher" />
  <label class="form-check-label" for="inlineRadio2">Teacher</label>
</div>

<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio"  id="admin" name="designation" value="admin" />
  <label class="form-check-label" for="inlineRadio3">Admin</label>
</div>
<div class="d-flex flex-row align-items-center mb-2">
<p class="deep-orange-text"><?php echo htmlspecialchars($error);?></p>
</div>


                  <div class="form-check d-flex justify-content-center mb-5">
                  </div>
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" name="register" value="Register" class="btn btn-primary btn-lg">Register</button>
                  </div>
                

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="../images/books.jpg" class="img-fluid" alt="Sample image">
				
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
	</body>