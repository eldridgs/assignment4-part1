<html>
<head>
    <meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="style.css">
    <title>Login to Library</title>
  </head>
  <body>
  <a href="newUser.php">New user?</a>
    <form method="POST" action="login.php">
	  <caption><h3>Please Log In</h3></caption>
	    <p>User Name:</p>
		<input type="text" name="username" id="username">
		<br>
		<p>Password:</p>
		<input type="password" name="password" id="password">
		<br><br>
		<input type="button" class="button" value="submit" onclick="authorize()">
		<br><br>
		<span id="status"></span>
	</form>
	<script type="text/javascript">
	function authorize() {
      var request;
	  var username = document.getElementById("username").value;
	  var password = document.getElementById("password").value;
	  if (username.length == 0 || password.length == 0) {
	     document.getElementById("status").innerHTML = "**Both user name and password required.**";
	  }
	  else {
	    var name = encodeURIComponent(username)+"&";
	    var pass = encodeURIComponent(password);
	    var pass2 = "password="+pass;
	    var send = name + pass2;
	    if (username.length > 0 && password.length > 0) {
	      request = new XMLHttpRequest();
	      request.onreadystatechange = function() {
		    if(request.readyState==4 && request.status==200) {
		      document.getElementById("status").innerHTML = request.responseText; 
		    }
	      };
	      request.open("GET", "authenticate.php?username="+send, true); 
	      request.send();
	  }
	  }
    };
	</script>
	<?php
	session_start();
	$name = $_SESSION["username"];
	?>
  </body>
</html>