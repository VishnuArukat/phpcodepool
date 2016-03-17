<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_function.php"); ?>

<?php 
	#setting the current_admin
	if (!find_admin_by_id($_GET["id"])) {
		redirect_to("manage_admins.php");
	} ?>
<?php 
	
	if(isset($_POST['submit'])) {

		# validation
		$required_fields = array("username", "password");
 	    validate_presences($required_fields);
 		$fields_with_max_lengths = array("username" => 30);
  		validate_max_lengths($fields_with_max_lengths);

		if (empty($errors)) {
			
			$username=mysql_prep($_POST["username"]);
			$hashed_password=mysql_prep($_POST["password"]);
			$id=$current_admin["id"];
		if ($current_admin["hashed_password"]==$hashed_password) {
			# code...
			$query  = "UPDATE admins SET ";
			$query .="username = '{$username}', ";
			$query .="hashed_password = '{$hashed_password}' ";
			$query .="WHERE id= {$id} ";
			$query .="LIMIT 1";
			$result = mysqli_query($connection,$query);

			if ($result && mysqli_affected_rows($connection)==1) {
				//success
				$_SESSION["message"] = "Admin Edited";
				redirect_to("manage_admins.php");
			}else{
				# failure

				$_SESSION["message"] = "Admin updation Failed";
				redirect_to("manage_admins.php");
			}
		}else{
			$_SESSION["message"] = "password does not match";
		}
			
		
	} else{//endof($errors)
		
		}

}// end of isset

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
	<h2>Edit Admin <?php echo htmlentities($current_admin["username"]); ?></h2> 
	<form action="edit_admin.php?id=<?php echo urlencode($current_admin["id"]); ?>" method="post">
		<p>
			Username
			<input type="text" name="username" value="<?php echo htmlentities($current_admin["username"]); ?>">
		</p>
		<P>
			Password
			<input type="password" name="password" value=""> 		
		</P>
		<input type="submit" name="submit" value="Edit Admin">
	</form>   
	<br />
	<a href="manage_admins.php">Cancel</a>

</div>
</div>
<?php include("../includes/layouts/footer.php"); ?>