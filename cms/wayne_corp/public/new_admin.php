<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_function.php"); ?>

<?php 
# form evaluvation
	if(isset($_POST['submit'])) {

		# validation
		$required_fields = array("username", "password");
 	    validate_presences($required_fields);
 		$fields_with_max_lengths = array("username" => 30);
  		validate_max_lengths($fields_with_max_lengths);

		if (empty($errors)) {
			
			$username=mysql_prep($_POST["username"]);
			$hashed_password=password_encryption(mysql_prep($_POST["password"]));

			$query = "INSERT INTO admins (";
			$query .="username,hashed_password";
			$query .= ") VALUES(";
			$query .="'{$username}','{$hashed_password}')";
			
			$result = mysqli_query($connection,$query);

			if ($result) {
				//success
				$_SESSION["message"] = "Admin Created";
				redirect_to("manage_admins.php");
			}else{
				# failure

				$_SESSION["message"] = "Admin Creation Failed";
			}
		}
	}else{
			 

	}

 ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
<div id="navigation">
	&nbsp;
</div> 
<div id="page">
	<?php echo session_message();?>

    <?php //$errors = session_errors(); 
    	  echo form_errors($errors);
    ?>
	<h2>Create Admin</h2> 
	<form action="new_admin.php" method="post">
		<p>
			Username
			<input type="text" name="username" value="">
		</p>
		<P>
			Password
			<input type="password" name="password" value=""> 		
		</P>
		<input type="submit" name="submit" value="Create Admin">
	</form>   
	<br />
	<a href="manage_admins.php">Cancel</a>

</div>
</div>
<?php include("../includes/layouts/footer.php"); ?>