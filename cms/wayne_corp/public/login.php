<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_function.php"); ?>

<?php 
	$username="";
# form evaluvation
	if(isset($_POST['submit'])) {

		# validation
		$required_fields = array("username", "password");
 	    validate_presences($required_fields);
  		if (empty($errors)) {

  			$username=$_POST["username"];
  			$password=$_POST["password"];
  			$found_admin=attempt_login($username,$password);

  			if ($found_admin) {
  					// marked as logged in

            if ($username==="Admin") {
              $_SESSION["admin_id"]=$found_admin["id"];
  					  $_SESSION["username"]=$username;
            	redirect_to("admin.php");
  					}else{
  						$_SESSION["admin_id"]=$found_admin["id"];
  						$_SESSION["username"]=$username;
  						redirect_to("index.php");	
  					}
  				}else{
  					$_SESSION["message"]="Username/Password is not correct";
  				}
  		}
	}
 
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<style>
  #hide{
    display: hidden;
  }
</style>
<div id="main">
<div id="navigation">
	&nbsp;
</div> 
<div id="page">
	<?php echo session_message();?>

    <?php //$errors = session_errors(); 
    	  echo form_errors($errors);
    ?>
	<h2>Log In</h2> 
	<form action="login.php" method="post">
		<p>
			Username
			<input type="text" name="username" value="<?php echo htmlentities($username); ?>">
		</p>
		<P>
			Password
			<input type="password" name="password" value=""> 		
		</P>
		<input type="submit" name="submit" value="submit">
	</form> 

</div>
</div>
<?php include("../includes/layouts/footer.php"); ?>