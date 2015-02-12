<?php
  if(!isset($_SERVER['HTTP_REFERER'])) {
    header("Location: login.php", true);
  }
  else {
    echo 'Here comes <a href="content1.php">content 1</a> !';
  }
?>