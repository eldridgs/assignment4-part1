<?php
  session_start();
  if(isset($_GET['action']) && $_GET['action'] == 'end') {
    session_destroy();
    header("Location: login.php", true);
    die();
  }
 ?>