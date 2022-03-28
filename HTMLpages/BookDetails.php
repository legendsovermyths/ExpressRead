<?php 

include('../config/connectDB.php');
    session_start();
    $college_id = $_SESSION['college_id'];
	$gr_num = $_SESSION['gr_no'];
	
	$sql = "select mem_id from member where college_id = '$college_id'";
	$result = mysqli_query($conn, $sql);
	$mem_ids = mysqli_fetch_assoc($result);
	$mem_id = $mem_ids['mem_id'];
	mysqli_free_result($result);
	$flipped_get = array_flip($_GET);
     
     if(isset($flipped_get['Delete']))
     {

		$copyno = mysqli_real_escape_string($conn, $flipped_get['Delete']);
          $sqls="delete from record where copy_no='$copyno' ";
           mysqli_query($conn, $sqls);

        $sqll="delete from copy where copy_no='$copyno' and gr_no='$gr_num' ";
         mysqli_query($conn, $sqll);

     }



	if(isset($flipped_get['Issue']))
	{
		$copyToIssue = mysqli_real_escape_string($conn, $flipped_get['Issue']);
		//echo "issue copy ". $copyToIssue;
		$sql = "Select count(*) from record where issued_by = '$mem_id' and return_date is NULL";
		$result = mysqli_query($conn, $sql);
		$noOfBooksArr = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		$noOfBooks = $noOfBooksArr['count(*)'];
		// echo "<br>";
		// echo "no of unreturned books = " . $noOfBooks;
		// echo "<br>";
		$sql = "Select designation from member where mem_id = '$mem_id'";
		$result = mysqli_query($conn, $sql);
		$desigArr = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		$designation = $desigArr['designation'];
		// echo "designation = " . $designation;
		// echo "<br>";
		if($designation=='student')
		{
			$noOfIssueableBooks = 2;
			$duration = "+1 week";
		}
		else if($designation == 'non_teacher')
		{
			$noOfIssueableBooks = 4;
			$duration = "+1 month";
		}
		else
		{
			$noOfIssueableBooks = 5;
			$duration = "+3 months";
		}
		if($noOfBooks<$noOfIssueableBooks)
		{
			//issue book
			//due_date	review	issue_date	return_date	rating	issued_by	returned_by	gr_no	copy_no
			//$today_date = date("Y/m/d");
			//echo $today_date;
			$strt_d = strtotime("today");
			$today_date = date("Y/m/d", $strt_d);
			$end_d = strtotime($duration,$strt_d);
			$end_date = date("Y/m/d", $end_d);
			// echo "Start date = $today_date end date = $end_date <br>";
			$sql = "UPDATE copy set status=0 where gr_no = '$gr_num' AND copy_no=$copyToIssue";
			if(mysqli_query($conn, $sql)) {
			  	//echo "value updated<br>";
			} else {
			 	echo "<center>problem in updating Please contact library staff</center><br />";
			}
			$sql = "INSERT into record(due_date,review,issue_date,return_date,rating,issued_by,returned_by,gr_no,copy_no) values ('$end_date', NULL, '$today_date', NULL, NULL, $mem_id, NULL, '$gr_num', $copyToIssue)";
			if(mysqli_query($conn, $sql)) {
			  	echo "<center>You have Successfully reserved the book, please collect the book from the library</center><br>";
			  	$sql = "SELECT accession_id from record where due_date='$end_date' and issue_date = '$today_date' and issued_by = $mem_id and gr_no = '$gr_num' and copy_no=$copyToIssue";
			  	$result = mysqli_query($conn, $sql); 
			  	$accessionIdArr = mysqli_fetch_assoc($result);
				$accession_id = $accessionIdArr['accession_id'];
				mysqli_free_result($result);
			  	$sql = "Select name from book where gr_no = '$gr_num'";
			  	$result = mysqli_query($conn, $sql); 
			  	$bookNameArr = mysqli_fetch_assoc($result);
				$bookName = $bookNameArr['name'];
				mysqli_free_result($result);
				$sql1 = "SELECT first_name,last_name from author where author.auth_id IN (Select auth_id from book_author where gr_no = '$gr_num')";
				$result1 = mysqli_query($conn, $sql1);
				$authors = mysqli_fetch_all($result1);
				mysqli_free_result($result1);
				$auth = '';
				foreach ($authors as $author):
					$auth .= $author[0] . " " . $author[1] . ", ";
				endforeach;
				$sql = "select email,name from member where mem_id = $mem_id";
				$result = mysqli_query($conn, $sql); 
			  	$emailArr = mysqli_fetch_assoc($result);
				$email = $emailArr['email'];
				$name = $emailArr['name'];
				mysqli_free_result($result);

			  	$to_email = "$email";
				$subject = "Issue Book Email";
				$headers = "From: librarymody@gmail.com\r\n";
				//$headers .= "CC: susan@example.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$body = "
				<html>
				<head>
				  <title>Issue Book Email</title>
				</head>
				<body>
				  <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>MODY Library System</b></p><br>
				  <p>Dear $name($college_id)<br>
				  The following book has been issued by you today.<br>
				  $gr_num |$bookName |".substr($auth, 0, -2)."|Accession id: $accession_id
				  <br>
				  You are welcome to contact us at librarymody@gmail.com for any Queries.
				  <br>
				  Regards,
				  <br>
				  Librarian
				  </p>
				</body>
				</html>
				";
				if (mail($to_email, $subject, $body, $headers)) {
				    //echo "Email successfully sent to $to_email...";
				} else {
				    echo "Email sending failed...";
				}
			} else {
			 	 echo "<center>error reserving the book, please contact library staff" . mysqli_error($conn) . "</center><br />";
			}
		}
		else
		{
			//display error
			echo "<center>You Have already issued $noOfBooks books, please return some book before issuing the next</center><br />";
		}
		
	}
	if(isset($flipped_get['Waitlist']))
	{
		$bookToWaitlist = mysqli_real_escape_string($conn, $flipped_get['Waitlist']);
		// echo "Waitlist gr_no=" . $bookToWaitlist;
		$sql = "SELECT count(*) from record where gr_no = $gr_num and return_date IS NULL";
		$result = mysqli_query($conn, $sql);
		$alreadyIssuedArr = mysqli_fetch_assoc($result);
		$alreadyIssued = $alreadyIssuedArr['count(*)'];
		mysqli_free_result($result);
		if($alreadyIssued==1)
		{
			echo "<center>You have already issued this book, you cannot add yourself to the waitlist</center><br>";
		}
		else
		{
			$sql = "select count(*) from waitlist where gr_no = $gr_num";
			$result = mysqli_query($conn, $sql);
			$priority = mysqli_fetch_assoc($result);
			mysqli_free_result($result);
			// print_r($priority);
			// echo "<br>";
			$priorityNum = $priority['count(*)'];
			$priorityNum++;
			// echo "<br>";
			// echo "priority = $priorityNum";
			// echo "<br>";
			$college_id = $_SESSION['college_id'];
			$sql = "select mem_id from member where college_id = '$college_id'";
			$result = mysqli_query($conn, $sql);
			$mem_ids = mysqli_fetch_assoc($result);
			$mem_id = $mem_ids['mem_id'];
			mysqli_free_result($result);
			// echo "mem_id = $mem_id";
			// echo "<br>";
			$sql = "insert into waitlist values($mem_id,'$gr_num',$priorityNum)";
			if (mysqli_query($conn, $sql)) {
			  	echo "<center>You Have been added to the waitlist your waiting number is $priorityNum</center><br />";
			} else {
			  	echo "<center>You are already in the Waitlist of this book your waiting number is ". $priorityNum -1 . "</center><br />";
			}
		}
	}
	if(isset($flipped_get['Reserved']))
	{
		echo "<center>This Copy is reserved, you may issue any other copy or Add yourself to the waitlist</center><br />";
	}
	$sql = "SELECT b.gr_no,b.name,c.copy_no,p.pname,c.edition,b.category,l.shelf,l.section,l.floor,c.status from book b,copy c,publisher p,location l where b.gr_no='$gr_num' and b.gr_no=c.gr_no and b.pub_id=p.pub_id and l.loc_id=b.loc_id " ;
	$result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
	{
		$copyrecord=mysqli_fetch_all($result);
	}
	mysqli_free_result($result);
 ?>
 