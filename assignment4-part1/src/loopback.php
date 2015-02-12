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
	   if ( empty($_POST) ) {
	     echo '{"Type":"[POST]", "parameters":null}';
	   }
	   else {
	     echo '{"Type":"[POST]","parameters":' . $json;
	     echo '}';
	   }
	 }
	 else {
	   $json = json_encode($_GET);
	   if ( empty($_GET) ) {
	     echo '{"Type":"[GET]", "parameters":null}';
	   }
	   else {
	     echo '{"Type":"[POST]","parameters":' . $json;
	     echo '}';
	   }
	 }
	 ?>
  </body>
</html>