<?php
//connect to sql
//ini_set('display_errors', 'On');
include 'storedInfo.php';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ( !$mysqli || $mysqli->connect_errno ) {
  echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}
session_start();
$name = $_SESSION["username"];

$title = $_REQUEST['title'];
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$category = $_REQUEST['category'];
$subject = $_REQUEST['subject'];
$bookstatus = $_REQUEST['bookstatus'];
$copies = $_REQUEST['copies'];

//prepare
  if ( !($stmt = $mysqli->prepare("SELECT user_id FROM passuser WHERE user_name = '$name'")) ) {
	  echo 'Prepare failed: (' . $mysqli->errno . ') '. $mysqli->error;
	}
//bind and execute results
   	if (!$stmt->execute()) {
	  echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	if ( !$stmt->bind_result($outId) ) {
	  echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
	}
	$stmt->fetch();
	/* explicit close recommended */
    $stmt->close();
	
//prepare
  if ( !($stmt = $mysqli->prepare("SELECT COUNT(title) FROM library_book WHERE user_id = '$outId' AND title = '$title' AND author_f = '$fname' AND author_l = '$lname'")) ) {
	  echo 'Prepare failed: (' . $mysqli->errno . ') '. $mysqli->error;
	}
//bind and execute results
   	if (!$stmt->execute()) {
	  echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	if ( !$stmt->bind_result($outNum) ) {
	  echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
	}
	$stmt->fetch();
	/* explicit close recommended */
    $stmt->close();
if ($outNum == 1) {
  echo "**Title already exists in your libaray.**";
}
else {
/* Prepared statement, stage 1: prepare */
    if (!($stmt = $mysqli->prepare("INSERT INTO library_book(user_id, title, author_f, author_l, category, subject, status, numberCopies) VALUES (?, ?, ?, ?, ?, ?, ? ,?)"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
/* Prepared statement, stage 2: bind and execute */
    if (!$stmt->bind_param("isssssii", $outId, $title, $fname, $lname, $category, $subject, $bookstatus, $copies)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
/* explicit close recommended */
    $stmt->close();

  echo "BOOK SUCCESFULLY ADDED";
}  
?>