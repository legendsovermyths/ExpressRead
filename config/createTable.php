<?php
	
	include('connectDB.php');

	// sql to create table
  	$sql = "CREATE table member (
      mem_id int unsigned AUTO_INCREMENT,
      name varchar(30) not null,
      phone varchar(11) not null,
      email varchar(60) not null,
      designation varchar(15) not null,
      fine_due int,
      college_id varchar(20) not null,
      password varchar(20) not null,
      verification_status  int not null,
      CONSTRAINT PK1_member PRIMARY KEY(mem_id),
      CONSTRAINT UC_member UNIQUE (phone,email,college_id),
      CONSTRAINT UC1_member UNIQUE (email)
  	  )";

	if (mysqli_query($conn, $sql)) {
	  echo "Table member created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "CREATE TABLE publisher (
	pub_id INT UNSIGNED AUTO_INCREMENT,
	pname VARCHAR(50) NOT NULL,
	contact_no VARCHAR(11),
	email VARCHAR(60),
	CONSTRAINT PK1_publisher PRIMARY KEY(pub_id)
	)";

	if (mysqli_query($conn, $sql)) {
	  echo "Table publisher created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "CREATE TABLE location (
	loc_id INT UNSIGNED AUTO_INCREMENT,
	shelf INT UNSIGNED,
	section INT UNSIGNED,
	floor INT UNSIGNED,
	CONSTRAINT PK1_location PRIMARY KEY(loc_id),
	CONSTRAINT UC_location UNIQUE (shelf,section,floor)
	)";

	if (mysqli_query($conn, $sql)) {
	  echo "Table location created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "CREATE table book(
	  gr_no varchar(20),
	  name varchar(50) not null,
	  category varchar(30) not null,
	  rating int,
	  pub_id INT UNSIGNED NOT null,
	  loc_id INT UNSIGNED NOT NULL,
	  CONSTRAINT PK1_book PRIMARY KEY(gr_no),
	  CONSTRAINT FK1_book FOREIGN KEY(pub_id) REFERENCES publisher(pub_id),
	  CONSTRAINT FK2_book FOREIGN KEY(loc_id) REFERENCES location(loc_id),
	  CONSTRAINT UC_book UNIQUE (name)
	  )";

	if (mysqli_query($conn, $sql)) {
	  echo "Table book created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";;
	}

	$sql = "CREATE table copy(
	  gr_no varchar(20),
	  copy_no int,
	  status int not null,
	  edition int,
	  mrp int,
	  actual_price int,
	  gifted_bought int,
	  conditions int not null,
	  CONSTRAINT PK1_copy PRIMARY KEY(gr_no,copy_no),
	  CONSTRAINT FK1_copy FOREIGN KEY(gr_no) REFERENCES book(gr_no)
	  )";

	if (mysqli_query($conn, $sql)) {
	  echo "Table copy created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "CREATE table record(
       accession_id int unsigned AUTO_INCREMENT,
       due_date DATE not null,
       review varchar(200),
       issue_date DATE not null,
       return_date DATE,
       rating int,
       issued_by int unsigned not null,
       returned_by int unsigned,
 	   gr_no varchar(20) not null,
       copy_no  int not null,
       CONSTRAINT PK_record PRIMARY KEY(accession_id),
       CONSTRAINT FK1_record FOREIGN KEY(issued_by) REFERENCES member(mem_id),
	   CONSTRAINT FK2_record FOREIGN KEY(returned_by) REFERENCES member(mem_id),
	   CONSTRAINT FK3_record FOREIGN KEY(gr_no,copy_no) REFERENCES copy(gr_no,copy_no)
	  )";

	if (mysqli_query($conn, $sql)) {
	  echo "Table record created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "CREATE TABLE author (
	auth_id INT UNSIGNED AUTO_INCREMENT,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	CONSTRAINT PK1_author PRIMARY KEY(auth_id)
	)";

	if (mysqli_query($conn, $sql)) {
	  echo "Table author created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}

	$sql = "CREATE TABLE book_author (
	gr_no VARCHAR(20),
	auth_id INT UNSIGNED,
	CONSTRAINT PK1_book_author PRIMARY KEY(gr_no,auth_id),
	CONSTRAINT FK1_book_author FOREIGN KEY(gr_no) REFERENCES book(gr_no),
	CONSTRAINT FK2_book_author FOREIGN KEY(auth_id) REFERENCES author(auth_id)
	)";

	if (mysqli_query($conn, $sql)) {
	  echo "Table book_author created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}


	$sql = "CREATE TABLE waitlist (
	mem_id INT UNSIGNED,
	gr_no VARCHAR(20),
	priority_no INT UNSIGNED NOT NULL,
	CONSTRAINT PK1_waitlist PRIMARY KEY(mem_id, gr_no),
	CONSTRAINT FK1_waitlist FOREIGN KEY(mem_id) REFERENCES member(mem_id),
	CONSTRAINT FK2_waitlist FOREIGN KEY(gr_no) REFERENCES book(gr_no)
	)";
	if (mysqli_query($conn, $sql)) {
	  echo "Table waitlist created successfully <br />";
	} else {
	  echo "Error creating table: " . mysqli_error($conn) . "<br />";
	}
	mysqli_close($conn);
?>