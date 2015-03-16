<?php
session_start();
if ( empty($_SESSION['username']) && empty($_POST['username']) ) {
      echo 'A username must be entered. <a href="login.php">  Login?</a>';
  }
else{
$name = $_SESSION["username"];

//connect to sql
//ini_set('display_errors', 'On');
include 'storedInfo.php';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ( !$mysqli || $mysqli->connect_errno ) {
  echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}
echo '<html>
  <head>
    <meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
    <title>Login to Library</title>
  </head>
  <body>
  echo "<a href=\'logout.php?action=end\'>Logout?</a><br>
  <a href="addbook.php">Add a book?</a>
  <h3>Your Library</h3>';

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
	//prepare results
    if ( !($stmt = $mysqli->prepare("SELECT book_id, title, author_f, author_l, category, subject, status, numberCopies FROM library_book WHERE user_id = '$outId'")) ) {
	  echo 'Prepare failed: (' . $mysqli->errno . ') '. $mysqli->error;
	}
//bind and execute results
   	if (!$stmt->execute()) {
	  echo 'Execute failed: (' . $mysqli->errno . ') ' . $mysqli->error;
	}
	if ( !$stmt->bind_result($id, $outTitle, $outfname, $outlname, $outcategory, $outsubject, $outstatus, $outnumber) ) {
	  echo 'Binding output parameters failed: (' .$stmt->errno . ') ' . $stmt->error;
	}
    echo '<table border="1">';
    echo '<thead><th>TITLE</th><th>AUTHOR</th><th>CATEGORY</th><th>SUBJECT</th><th>NUMBER of COPIES</th><th>STATUS</th><th></th><th></th></thead>';
    echo '<tbody>';
    $i = 0;
    while ( $stmt->fetch() ) {
	$i++;
      if ( $outnumber == 0 ) {
      $rentalStatus = 'Checked Out';
	  $checkInOut = 'Check In';
      }
      else {
        $rentalStatus = 'Checked In';
		$checkInOut = 'Check Out';
      }
      //$videoName = $outName;
      echo '<tr>
              <td>' . $outTitle . '</td>
    		  <td>' . $outfname . ' ' . $outlname .'</td>
			  <td>' . $outcategory . '</td>
			  <td>' . $outsubject . '</td>
			  <td>' . $outnumber . '</td>
		      <td>' . $rentalStatus . '</td>';
	  if ( $outnumber == 0 ) {
	    echo '<td><form action="delete.php" method="POST"><input type="hidden" name="checkIn" value ="' . $id . '"><input type="submit" class="button" value="' . $checkInOut . '"></form></td>';
	  }
	  else {
	    echo '<td><form action="delete.php" method="POST"><input type="hidden" name="checkOut" value ="' . $id . '"><input type="submit" class="button" value="' . $checkInOut . '"></form></td>';
	  }
	  echo '<td><form action="delete.php" method="POST"><input type="hidden" name="deleteName" value="' . $id . '"><input type="submit" class="button" value="Remove Book"></form></td>';
	}
    echo '</table><br>';
    echo '<form action="delete.php" method="POST"><input type="submit" class="button" name="deleteAll" value="Remove All"></form>';
/* explicit close recommended */
    $stmt->close();
}
	?>
  </body>
 </html>

  