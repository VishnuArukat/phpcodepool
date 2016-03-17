<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php 
	// V1 ;distroying sessions and redirecting to the login.phpzz

	  $_SESSION["admin_id"]=null;

      $_SESSION["username"]=null;
      redirect_to("login.php");
 ?>
 <?php 
 	//V3 destroying all sessions
 //	session_start();
// 	$_SESSION=array();

 	//if (isset($_COOKIE[session_name()])) {
 	//	setcookie(session_name(),'',time()-42000, '/');
 	//}
 //	session_destroy();
// 	redirect_to("login.php");
  ?>