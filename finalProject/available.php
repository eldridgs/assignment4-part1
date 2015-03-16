<?php
$name = $_REQUEST['username'];
if ( strpos($name, " ") !== false ) { //check for whitespace
  echo "**No spaces allowed.**";
}
else {
//connect to sql
  //ini_set('display_errors', 'On');
  include 'storedInfo.php';
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ( !$mysqli || $mysqli->connect_errno ) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
  }
  //prepare
  if ( !($stmt = $mysqli->prepare("SELECT user_name FROM passuser WHERE user_name = '$name'")) ) {
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
	  if ($outName != NULL) {
	    echo "**Username not available.**";
	  }
}
?>