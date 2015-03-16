<?php
//connect to sql
//ini_set('display_errors', 'On');
include 'storedInfo.php';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ( !$mysqli || $mysqli->connect_errno ) {
  echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}

$name = $_REQUEST['username'];
$pass = $_REQUEST['password'];
  //prepare
  if ( !($stmt = $mysqli->prepare("SELECT COUNT(user_name) FROM passuser WHERE user_name = '$name'")) ) {
	  echo 'Prepare failed: (' . $mysqli->errno . ') '. $mysqli->error;
	}
//bind and execute results
   	if (!$stmt->execute()) {
	  echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	if ( !$stmt->bind_result($outName) ) {
	  echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
	}
	$stmt->fetch();
	/* explicit close recommended */
    $stmt->close();
	  if ($outName != 1) {
	    echo "**Username not recognized.**";
	  }
	  else {
	  //prepare
  if ( !($stmt = $mysqli->prepare("SELECT user_pass FROM passuser WHERE user_name = '$name'")) ) {
	  echo 'Prepare failed: (' . $mysqli->errno . ') '. $mysqli->error;
	}
//bind and execute results
   	if (!$stmt->execute()) {
	  echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	if ( !$stmt->bind_result($outPass) ) {
	  echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
	}
	$stmt->fetch();
	/* explicit close recommended */
    $stmt->close();
	if ($outPass != $pass) {
	  echo "**Wrong password entered.**";
	}
	else {
	session_start();
	$_SESSION["username"] = $name;
	echo "<font color='black'>WELCOME BACK, " . $name . "!</font><br><br>";
	echo "<a href='addbook.php?username=" . $name . "'>Add a book?  </a><br>";
	echo "<a href='library.php?username=" .$name . "'>Search your books?</a><br>";
	echo "<a href='logout.php?action=end'>Logout?</a>";
	}
}
?>