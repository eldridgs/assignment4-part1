<?php
  session_start();
  if(isset($_GET['action']) && $_GET['action'] == 'end') {
    session_destroy();
    header("Location: login.php", true);
    die();
  }
  else{
    if ( empty($_POST) && !isset($_SESSION['count']) ) {
	  header("Location: login.php", true);
	}
    elseif ( empty($_SESSION['username']) && empty($_POST['username']) ) {
      echo 'A username must be entered. Click <a href="login.php">here</a> to return to the login screen.';
  }
    else{
      if(session_status() == PHP_SESSION_ACTIVE){
        if(!isset($_SESSION['count'])){
          $_SESSION['count'] = 0;
		  $_SESSION['username'] = $_POST['username'];
        }
        //$_SESSION['username'] = $_POST['username'];
        echo 'Hello, ' . $_SESSION[username] .'.  You have visited this page ' . $_SESSION[count] . ' times before. ';
        echo '  Click <a href="https://web.engr.oregonstate.edu/~eldridgs/src/content1.php?action=end">here</a> to log out.';
		echo '  Look out!  Here comes <a href="content2.php">content 2</a>.';
        $_SESSION['count']++;
      }
    }  
  }
?>