<?php
  //ini_set('display_errors', 'On');
  include 'storedInfo.php';
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ( !$mysqli || $mysqli->connect_errno ) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
  }
?>
<html>
<head>
    <meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
    <title>Create Login</title>
  </head>
  <body>
  <a href="login.php">Login?</a>
    <form method="POST" action="newUser.php">
	  <caption><h3>Choose</h3></caption>
	    <p>User Name:</p>
		<input type="text" name="username" id="username" oninput="checkAvailable()">
		<span id="status"></span>
		<br>
		<p>Password:</p>
		<input type="password" name="password">
		<br><br>
		<input type="submit" class="button" id="submit" value="submit">
	</form>
	<script type="text/javascript">
	function checkAvailable() {
	  var request;
	  var name = document.getElementById("username").value;
	  if (name.length >= 5){
	    request = new XMLHttpRequest();
		request.onreadystatechange = function() {
		  if(request.readyState==4 && request.status==200) {
		    document.getElementById("status").innerHTML = request.responseText;
		  }
		};
		request.open("GET", "available.php?username="+encodeURIComponent(username.value), true); //encodeURIComponent encodes special characters
		request.send();
	  }
	  else {
	    document.getElementById("status").innerHTML = "**User name must be at least 5 characters.**";
	  }
	};
	</script>
<?php
//check for empty form fields
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ( empty($_POST["username"]) ) {
	echo "<div id='red'>**Username is required.**</div>";
	$validInput = false;
  }
  elseif ( empty($_POST["password"]) ) {
	echo "<div id='red'>**Password is required.**</div>";
	$validInput = false;
  }
//check if username is 5 characters long
  elseif ( strlen($_POST["username"]) < 5 ){
    echo "<div id='red'>**User name must be at least 5 characters long.**</div>";
	$validInput = false;
  }
//check for whitespace
  elseif ( strpos($_POST["username"], " ") !== false ) {
      echo "<div id='red'>**No spaces allowed.**</div>";
	  $validInput = false;
  }
  elseif ( strpos($_POST["password"], " ") !== false){
	echo "<div id='red'>**No spaces allowed.**</div>";
	$validInput = false;
  }
  else  {
    $name = $_POST["username"];
	$pass = $_POST["password"];
	$validInput = true;
  }
  
//input is valid
if ($validInput == true) {
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
	  //echo "outname is" .$outName;
	  
/* explicit close recommended */
    $stmt->close();
	if ($outName == $name) {
	  echo "<div id='red'>**Username NOT available.**</div>";
	}
	
    else {
/* Prepared statement, stage 1: prepare */
    if (!($stmt = $mysqli->prepare("INSERT INTO passuser(user_name, user_pass) VALUES (?, ?)"))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
    }
	$rented = 0;
/* Prepared statement, stage 2: bind and execute */
    if (!$stmt->bind_param("ss", $name, $pass)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }
    if (!$stmt->execute()) {
     // echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }
/* explicit close recommended */
    $stmt->close();
	
	echo "Username and password saved!<br>";
	echo "<a href='login.php'>Login?</a>";
	}
}
}
?>	
  </body>
</html>