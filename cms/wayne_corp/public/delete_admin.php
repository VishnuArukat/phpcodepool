<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>


<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
<?php 

	$current_admin = find_admin_by_id($_GET["id"]);
	if (!$current_admin) {
			#not setted
			redirect_to("manage_admins.php");

				}else{

		$id=$_GET["id"];
		$query="DELETE FROM admins ";
		$query .= "WHERE id={$id} LIMIT 1";
		$result=mysqli_query($connection,$query);

		if ($result && mysqli_affected_rows($connection)) {
			#success
			$_SESSION["message"] = "Admin Deleted .";
			redirect_to("manage_admins.php");
		}else{
			#failure
			$_SESSION["message"] = "Admin Deletion Failed.";
			redirect_to("manage_admins.php");
		}
	}
# no need for footer as it run on BG 
 ?>

