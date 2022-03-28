<?php
	include('config/connectDB.php');
	$error = '';
	$college_id = '';
	if(isset($_POST['college_id']))
	{
		$error = '';
		$college_id = mysqli_real_escape_string($conn, $_POST['college_id']);
		$passwordEntered = mysqli_real_escape_string($conn, $_POST['password']);
		$sql = "SELECT password FROM member where college_id = '$college_id' and verification_status = 1";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0)
		{
			$passwordActual = mysqli_fetch_assoc($result);
			if($passwordActual['password']===$passwordEntered)
			{
				session_start();
				$_SESSION['college_id'] = $college_id;
				header('Location: HTMLpages/userhomepage.php');
			}
			else
			{
				$error = "Incorrect password";
			}
		}
		else
		{
			$error = "No such user exists";
		}
		mysqli_free_result($result);
	}
	mysqli_close($conn);
?>
<!doctype html>
<html>
	<head>
    <!-- Font Awesome -->
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
<link rel="stylesheet"  href="CSS/index_style2.css">
		<meta charset="utf-8" />
		
		<title>Welcome to our Library Management System</title>
		
	</head>
	<body>
    <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"
></script>
<section class="vh-100">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6 text-black">

        <div class="px-5 ms-xl-4" >
          <i class="fas fa-book-open fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;padding-left:9px;"></i>
          <span class="h1 fw-bold mb-0">ExpressRead</span>
        </div>

        <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

          <form style="width: 23rem;" action="index.php" method = "POST">

            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; padding-left:13px">Log in</h3>

            <div class="form-outline mb-4">
              <input type="text" name="college_id" id="formControlLg" class="form-control form-control-lg" />
              <label class="form-label" for="form2Example18">College ID</label>
            </div>

            <div class="form-outline mb-4">
              <input type="password" name="password" id="form2Example28" class="form-control form-control-lg" />
              <label class="form-label" for="form2Example28">Password</label>
            </div>

            <div class="pt-1 mb-4">
              <button class="btn btn-info btn-lg btn-block" name = "sign_in" value = "Sign in" type="submit">Login</button>
            </div>
            <div class = "red_text"><?php echo $error ?></div>
            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
            <p>Don't have an account? <a href="./HTMLpages/Signup.php" class="link-info">Register here</a></p>
 
          </form>

        </div>

      </div>
      <div class="col-sm-6 px-0 d-none d-sm-block">
        <img src="./images/home.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
      </div>
    </div>
  </div>
</section>
    </body>