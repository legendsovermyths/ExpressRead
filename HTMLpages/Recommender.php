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