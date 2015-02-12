<!DOCTYPE html>
<html>
 <head>
   <meta charset="UTF-8" />
   <title>LOOPBACK</title>
   </head>
   <body>
	 <h1>LOOPBACK</h1>
	 <?php
	 $req_type = $_SERVER['REQUEST_METHOD'];
	 if ( $req_type == 'POST' ) {
	   $json = json_encode($_POST);
	   echo '{"Type":"[POST]","parameters":' . $json;
	  // echo '}';
	   }
	 }
	 else {
	   foreach ( $_GET as $key => $value) {
	     echo 'GET';
	   }
	 }
	 ?>
  </body>
</html>