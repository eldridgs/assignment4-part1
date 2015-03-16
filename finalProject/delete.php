<?php
  include 'storedInfo.php';
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ( !$mysqli || $mysqli->connect_errno ) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ( isset($_POST['deleteAll']) ) {
        $mysqli->query("DELETE* FROM library_book");
      }
      if ( isset($_POST['deleteName']) ) {
	    $bookid = $_POST['deleteName'];
	    $mysqli->query("DELETE FROM library_book WHERE book_id = '$bookid'");
	  }
	  if ( isset($_POST['checkOut']) ) {
	    $bookid = $_POST['checkOut'];
//prepare
  if ( !($stmt = $mysqli->prepare("SELECT numberCopies FROM library_book WHERE book_id = '$bookid'")) ) {
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
	$outNum = $outNum - 1;
		$mysqli->query("UPDATE library_book SET numberCopies = '$outNum' WHERE book_id = '$bookid'");
	  }  
	  
	  if ( isset($_POST['checkIn']) ) {
	    $bookid = $_POST['checkIn'];
		//prepare
  if ( !($stmt = $mysqli->prepare("SELECT numberCopies FROM library_book WHERE book_id = '$bookid'")) ) {
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
	$outNum = $outNum + 1;
		$mysqli->query("UPDATE library_book SET numberCopies = '$outNum' WHERE book_id='$bookid'");
	  } 
	}
    header('Location: library.php', true);
?> 