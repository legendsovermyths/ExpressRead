<?php
	include('connectDB.php');

	$sql = "insert into member values(
1, 'Aditya Mukherjee','7984555990','aditya@hyderabad.bitspilani.ac.in','head_librarian',0,'LIBRARY','hellostudents',1)";

if(mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


$sql = "insert into member values(2,'Farhaan Tinwala','7976509883','farhaan@hyderabad.bitspilani.ac.in','admin',0,'2017LB0001H','shinchanNuhara',1)";


if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


$sql = "insert into member values(
3, 'Manav Bhagchandani', '7984555986','f20191343@hyderabad.bits-pilani.ac.in','student',0,'2019A7PS1343H', '123456',1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}



$sql = "insert into member values(
4, 'Yashank Garg','7984555987','f20191344@hyderabad.bits-pilani.ac.in','student',
0,'2019A7PS1344H','9876543210',1)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}



$sql = "insert into member values(
5, 'Diya Goyal','7984555988','f20191345@hyderabad.bits-pilani.ac.in','student',
0,'2019A7PS1345H','1234',1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


$sql = "insert into member values(
6, 'Ojashvi Tarunabh','7984555989','f20191346@hyderabad.bits-pilani.ac.in','student',
0,'2019A7PS1346H','helloworld',1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


	$sql = "insert into publisher values(
1,'scholastic', 9876543212,'scholastic@scholastic.com'
)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into publisher values(
2,'oxford', '9876543211','oxford@oxford.com'
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into publisher values(
3,'harper', '9876543210','harper@harper.com'
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

	$sql = "insert into location values(1,1,1,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into location values(2,2,1,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}



$sql = "insert into book values(
1,'harry potter and the chamber of secrets','fiction',4.5,1,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into book values(
2,'harry potter and the prisioner of askaban','fiction',3,1,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}



$sql = "insert into book values(
3,'percy jackson and the lightning thief','fiction',4,2,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}




$sql = "insert into book values(
4,'percy jackson and the sea of monsters','fiction',4,2,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}



$sql = "insert into book values(
5,'percy jackson and the battle of lybrinth','fiction',3,2,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


$sql = "insert into book values(
6,'the subtle art of not caring','self help',5,3,2
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}



$sql = "insert into copy values(
1,1,1,1,1,1,1,1
)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into copy values(
1,2,1,1,500,0,0,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into copy values(
2,1,1,1,600,400,1,1
)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into copy values(
3,1,1,1,550,550,1,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into copy values(
4,1,1,1,400,400,1,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into copy values(
5,1,1,1,800,0,0,1
)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into copy values(
6,1,1,1,1100,800,1,1
)";

if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}






$sql = "insert into author values(1,'Joanne Kathleen','Rowling')";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into author values(2,'Rick','Riordan')";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into author values(3,'Mark','Manson')";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


$sql = "insert into book_author values(1,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into book_author values(2,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into book_author values(3,2)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into book_author values(4,2)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into book_author values(5,2)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into book_author values(6,3)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted <br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}

$sql = "insert into record values(1,'2021/04/23',NULL,'2021/04/03','2021/04/08',NULL,3,2,1,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(2,'2021/04/23',NULL,'2021/04/03','2021/04/08',NULL,3,2,2,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(3,'2021/04/23',NULL,'2021/04/03','2021/04/08',NULL,3,2,3,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(4,'2021/04/23',NULL,'2021/04/03','2021/04/08',NULL,3,2,4,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(5,'2021/04/23',NULL,'2021/04/03',NULL,NULL,3,NULL,5,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(6,'2021/04/23',NULL,'2021/04/03','2021/04/10',NULL,3,2,5,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(7,'2021/04/25',NULL,'2021/04/07','2021/04/11',NULL,3,2,5,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}
$sql = "insert into record values(8,'2021/04/25',NULL,'2021/04/07',NULL,NULL,3,NULL,5,1)";
if (mysqli_query($conn, $sql)) {
	  echo "values inserted for record<br />";
	} else {
	  echo "error instering values: " . mysqli_error($conn) . "<br />";
	}


	mysqli_close($conn);
?>