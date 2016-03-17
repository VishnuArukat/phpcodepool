<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>

<?php
	$current_page= find_page_by_id($_GET["page"],$public=false);
  if (!$current_page){
    // if current subject was null or invalid
    redirect_to("manage_content.php");
  }
 

  $id= $current_page["id"];
  $query= "DELETE FROM pages WHERE id = {$id} LIMIT 1";

  $result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) == 1 ) {
			// Success
			$_SESSION["message"] = "page Deleted .";
			redirect_to("manage_content.php");
		}else{
			// failure
			$_SESSION["message"] = "page Deletion failed .";
			redirect_to("manage_content.php?page={$id}");
		}
  ?>

