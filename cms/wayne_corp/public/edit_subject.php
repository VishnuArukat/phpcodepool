<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_function.php"); ?>
<?php
	// calling func to check whether page and subject are set
    find_selected_page();
?>
<?php
  if (!$current_subject){
    // if current subject was null or invalid
    redirect_to("manage_content.php");
  }
  ?>

<?php
	// processing in single page
	if (isset($_POST['submit'])) {
		// Process the form
		// $menu_name = mysql_prep($menu_name);//for escaping
		//validations
		$required_fields  = array("menu_name","position","visible" );
		validate_presences($required_fields);

		$fields_with_max_lenghts = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lenghts);
		if (empty($errors)) {
			
		$id 		= $current_subject["id"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
    // hve to check
    // $new=swap_new($position);

		$query  = "UPDATE subjects SET ";
		$query .= "menu_name ='{$menu_name}', "; // 2 dble qtes bcoz its a strng
		$query .= "position = {$position}, ";
		$query .= "visible={$visible} ";
		$query .= "WHERE id={$id} ";
		$query .="LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0 ) {
			// Success
			$_SESSION["message"] = "Subject updated .";

			redirect_to("manage_content.php");
		} else {  
			// Failure
		
    $message = "Subject updating failed."; 
			
		}
		
		}

	} else {
		// This is probably a GET request
		//redirect_to("new_subject.php"); don't need this
	}

?>
 <?php $layer_context = "admin"; ?>
<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
		<div id="main">
  <div id="navigation">
    <br />
        <a href="admin.php">&laquo; Main Menu</a><br />
    
  	<?php echo  navigatiion($current_subject,$current_page); // passing the assoc  array current of pages and subjects ?>

  </div>
  <div id="page">
   <?php
   	// message is a variable not a session
    $message="Subject updating failed.";
   		if(!empty($errors)){ 
   			echo "<div class= \"message\">". htmlentities($message) . "</div>";
   		}
   ?>
   
    <?php echo form_errors($errors); ?>
      <h2>Edit Subject : <?php echo htmlentities($current_subject["menu_name"]);?></h2>

    <form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>"  method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]);?>" />
      </p>
      <p>Position:
        <select name="position">
          <?php
          $subject_set= find_subjects(false);
              $subject_count = mysqli_num_rows($subject_set); // for counting the rows in the table
          for ($count=1; $count <=$subject_count ; $count++) {  
              echo "<option value =\"{$count}\"";
              if ($current_subject["position"]== $count){
              	echo "Selected";
              }
              echo ">{$count}</option>";          
          }
        //  $prev=swap_current($current_subject["position"]);
            
          ?>
        
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" <?php if ($current_subject["visible"]== 0){echo "checked"; }?> /> No
        &nbsp;
        <input type="radio" name="visible" value="1" <?php if ($current_subject["visible"]== 1){echo "checked"; }?> /> Yes
      </p>
      <input type="submit" name="submit" value="Edit Subject" />
    </form>
    <br />
    <a href="manage_content.php">Cancel</a>  
    &nbsp;<!--Non breaking space!-->
    &nbsp;
    <a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick= "return confirm('Are u Damn Sure?');">Delete Subject</a>  
     
      
  </div>
</div>
		<?php	// Release the return data is in functions.php?>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

