<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_function.php"); ?>
<?php
	// calling func to check whether page and subject are set
    find_selected_page();
?>
<?php
  if (!$current_page){
    // Unlike new_page.php, we don't need a subject_id to be sent
    // We already have it stored in pages.subject_id.
    redirect_to("manage_content.php");
  }
  ?>

<?php
	// processing in single page
	if (isset($_POST['submit'])) {
		// Process the form
		// $menu_name = mysql_prep($menu_name);//for escaping
		//validations
    
    
		
    $id     = $current_page["id"];
    $menu_name = mysql_prep($_POST["menu_name"]);
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];
    $content = mysql_prep($_POST["content"]);


    $required_fields  = array("menu_name","position","visible","content");
		validate_presences($required_fields);

		$fields_with_max_lenghts = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lenghts);
		if (empty($errors)) {
			
    // hve to check
    // $new=swap_new($position);
    

    $query  = "UPDATE pages SET ";
    $query .= "menu_name = '{$menu_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result= mysqli_query($connection,$query);

	if ($result && mysqli_affected_rows($connection) >= 0 ) {
			// Success
			$_SESSION["message"] = "Page updated .";

			redirect_to("manage_content.php?page={$id}");
		} else {  
			// Failure
		
    $message = "Page updating failed."; 
			
		}
		
		} else{
      echo "errors .";
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
   	//message is a variable not a session
   $message="Page updating failed.";
   	if(!empty($errors)){ 
   		echo "<div class= \"message\">". htmlentities($message) . "</div>";
   	}
   ?>
    <?php echo session_message();?>
    <?php echo form_errors($errors); ?>
      <h2>Edit Page : <?php echo htmlentities($current_page["menu_name"]);?></h2>

    <form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>"  method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]);?>"/>
      </p>
      <p>Position:
        <select name="position">
          <?php // not passing subject_id as get variable so use pages.subject_id
          $page_set= find_pages($current_page["subject_id"],false);
              $page_count = mysqli_num_rows($page_set); // for counting the rows in the table
          for ($count=1; $count <=$page_count ; $count++) {  
              echo "<option value =\"{$count}\"";
              if ($current_page["position"]== $count){
              	echo "Selected";
              }
              echo ">{$count}</option>";          
          }     
          ?>
          
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" <?php if ($current_page["visible"]== 0){echo "checked"; }?> /> No
        &nbsp;
        <input type="radio" name="visible" value="1" <?php if ($current_page["visible"]== 1){echo "checked"; }?> /> Yes
      </p>
      <p>Content: <br />
        <textarea name ="content" rows="20" cols="80"><?php echo htmlentities($current_page["content"]); ?></textarea>
      </p>
      <input type="submit" name="submit" value="Edit Page" />
    </form>
    <br />
    <a href="manage_content.php?page=<?php echo urlencode($current_page["id"]);?>">Cancel</a>  
    &nbsp;<!--Non breaking space!-->
    &nbsp;
    <a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick= "return confirm('Are u Damn Sure?');">Delete Page</a>  
     
      
  </div>
</div>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

