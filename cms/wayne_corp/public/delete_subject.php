<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>

<?php
	$current_subject= find_subject_by_id($_GET["subject"],false);
  if (!$current_subject){
    // if current subject was null or invalid
    redirect_to("manage_content.php");
  }
  $page_set= find_pages($current_subject["id"]);
  	if (mysqli_num_rows($page_set)>0) {

  		$_SESSION["message"] = "Subject with pages cannot be deleted  .";
		redirect_to("manage_content.php?subject={$current_subject["id"]}");
  	}

  $id= $current_subject["id"];
  $query= "DELETE FROM subjects WHERE id = {$id} LIMIT 1";

  $result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) == 1 ) {
			// Success
			$_SESSION["message"] = "Subject Deleted .";
			redirect_to("manage_content.php");
		}else{
			// failure
			$_SESSION["message"] = "Subject Deletion failed .";
			redirect_to("manage_content.php?subject={$id}");
		}
  ?>

