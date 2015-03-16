<?php
  //ini_set('display_errors', 'On');
  include 'storedInfo.php';
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if ( !$mysqli || $mysqli->connect_errno ) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
  }
  session_start();
  $name = $_SESSION["username"];
?>
<html>
  <head>
    <meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
    <title>Add Book to Library</title>
  </head>
  <body onload="notfilled()">
  <a href='logout.php?action=end'>Logout?</a><br>
  <a href="library.php">Search your books?</a>
  <h3>Add a Book</h3>
  <br>
    <form method="POST" action="addbook.php"">
      <span>Title:</span>
		    <input type="text" name="title" id="title" oninput="checkFilled()" onblur="isempty()">
			<span id="status"></span><br><br><br>
	  <span>Author's First Name:</span>
		    <input type="text" name="fname" id="fname" oninput="checkFilledA()" onblur="isempty()">
			<span id="statusA"></span><br><br>
	  <span>Author's Last Name:</span>
		    <input type="text" name="lname" id="lname" oninput="checkFilledB()" onblur="isempty()">
			<span id="statusB"></span><br><br><br>	
	  <span>Category:</span>
		    <select id="category">
			  <option value=""></option>
			  <option value="Children's">Children's</option>
			  <option value="Young Adult">Young Adult</option>
			  <option value="Biography">Biography</option>
			  <option value="Non-Fiction">Non-Fiction</option>
			  <option value="Literature">Literature</option>
			  <option value="Graphic Novel">Graphic Novel</option>
			  <option value="Romance">Romance</option>
			  <option value="Thrillers">Thrillers</option>
			  <option value="Western">Western</option>
			  <option value="Mystery">Mystery</option>
			  <option value="Poetry">Poetry</option>
			  <option value="Other">Other</option>
			</select><br><br><br>
	  <span>Subject:</span>
	    <input type="text" name="subject" id="subject"><br><br><br>
	  <span>Status:</span><br>
	    <input type="radio" name="bookstatus" id="bookstatus" value="checkedin">Checked In<br>
		<input type="radio" name="bookstatus" id="bookstatus" value="checkedout">Checked Out<br><br><br>
	  <span>Number of Copies:</span>
	    <input type="number" name="copies" id="copy" oninput="checkFilledC()" onblur="checkFilledC()">
		<span id="statusC"></span><br><br>
	  <input type="button" class="button" value="Add Book" onclick="addtitle()">
    </form>
	<span id="red"></span>
	<script type="text/javascript">
	  function addtitle() {
	    var title = document.getElementById("title").value;
		var fname = document.getElementById("fname").value;
		var lname = document.getElementById("lname").value;
		var category = document.getElementById("category").value;
		var subject = document.getElementById("subject").value;
		var status = document.getElementById("bookstatus").value;
		var bookstatus;
		var copies = document.getElementById("copy").value;
		if ( status === "checkedout" && copies > 0 ) {
		  copies = copies - 1;
		}
		
		var titleplus = encodeURIComponent(title) + "&fname=";
		var fnameplus = encodeURIComponent(fname) + "&lname=";
		var lnameplus = encodeURIComponent(lname) + "&category=";
		var categoryplus = encodeURIComponent(category) + "&subject=";
		var subjectplus = encodeURIComponent(subject) + "&bookstatus=";
		var bookstatusplus = encodeURIComponent(bookstatus) + "&copies=";
		
		var titlef = titleplus + fnameplus;
		var lnamecategory = lnameplus + categoryplus;
		var subjectstatus = subjectplus + bookstatusplus;
		
		var titlecategory = titlef + lnamecategory;
		
		var titlestatus = titlecategory + subjectstatus;
		
		var send =  titlestatus + encodeURIComponent(copies);
//trim whitespace from strings for user error
		title.trim();
		fname.trim();
		lname.trim();
		subject.trim();
		if (title === "" || fname === "" || lname === "" || copies === "") {
		  document.getElementById("red").innerHTML = "**REQUIRED FEILD MISSING.**";
		}
		else if ( copies < 0 ) {
		  document.getElementById("red").innerHTML = "**Number of Copies cannot be negative.**";
		}
		else {
//check for already in database or add to database
        var request = new XMLHttpRequest();
	      request.onreadystatechange = function() {
		    if(request.readyState==4 && request.status==200) {
		      document.getElementById("red").innerHTML = request.responseText; 
		    }
	      };
	      request.open("GET", "add.php?title=" + send, true); 
	      request.send();
		}
	  };
	  function notfilled() {
	    document.getElementById("status").innerHTML = "**REQUIRED**";
		document.getElementById("statusA").innerHTML = "**REQUIRED**";
		document.getElementById("statusB").innerHTML = "**REQUIRED**";
		document.getElementById("statusC").innerHTML = "**REQUIRED**";
	  };
	  function checkFilled() {
	    var string = document.getElementById("title");
		if (typeof string != "unidentified") {
		  document.getElementById("status").innerHTML = "";
		}
	  };
	  function checkFilledA() {
	    var stringA = document.getElementById("fname");
		if (typeof stringA != "unidentified") {
		  document.getElementById("statusA").innerHTML = "";
		}
	  };
	  function checkFilledB() {
	    var string = document.getElementById("lname");
		if (typeof stringB != "unidentified") {
		  document.getElementById("statusB").innerHTML = "";
		}
	  };
	  function checkFilledC() {
	    var stringC = document.getElementById("copy");
		if (typeof stringC === "number") {
		  document.getElementById("statusC").innerHTML = "";
		}
	  };
	  function isempty() {
	    var string = document.getElementById("title").value;
		var stringA = document.getElementById("fname").value;
		var stringB = document.getElementById("lname").value;
		if (string === "") {
		  document.getElementById("status").innerHTML = "**REQUIRED**";
		}
		if (stringA === "") {
		  document.getElementById("statusA").innerHTML = "**REQUIRED**";
		}
		if (stringB === "") {
		  document.getElementById("statusB").innerHTML = "**REQUIRED**";
		}
	  }
	</script>
  </body>
</html>