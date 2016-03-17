<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/validation_function.php"); ?>
<?php
  // calling func to check whether page and subject are set
    find_selected_page();?>
<?php
  if (!$current_subject){
    // if current subject was null or invalid
    redirect_to("manage_content.php");
  }
  ?>

<?php
  if (isset($_POST['submit'])) {
    // Process the form
    
    // $menu_name = mysql_prep($menu_name);//for escaping
    //validations
    $required_fields  = array("menu_name","position","visible","content" );
    validate_presences($required_fields);

    $max_lenghts_menu_name = array("menu_name" => 30);
    validate_max_lengths($max_lenghts_menu_name);
   // if (!empty($errors)) {
     // $_SESSION["errors"]= $errors;
     // redirect_to("manage_content.php");
   // } 
    
  if (empty($errors)){

    
    $subject_id=$current_subject["id"];
    $menu_name = mysql_prep($_POST["menu_name"]);
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];
    $content = mysql_prep($_POST["content"]);

    $query  = "INSERT INTO pages (";
    $query .= " subject_id, menu_name, position, visible, content ";
    $query .= ") VALUES (";
    $query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible},'{$content}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "page created.";
      redirect_to("manage_content.php?subject=" . urlencode($current_subject["id"]));
    } else {  
      // Failure
      $_SESSION["message"] = "page creation failed."; 
      
    }
    
  } else {
    // This is probably a GET request
   // redirect_to("new_page.php");
  }
}

?>

<?php $layout_context = "admin"; ?>

<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
		<div id="main">
  <div id="navigation">
    <br />
       <a href="admin.php">&laquo; Main Menu</a><br />
    
  	<?php echo  navigatiion($current_subject,$current_page); // passing the assoc  array current of pages and subjects ?>

  </div>
  <div id="page">
    <?php
    // outputing the message 
    echo session_message();
    ?>
    <?php //$errors = session_errors(); ?>
    <?php echo form_errors($errors); ?>
      <h2>Create Page</h2>

    <form action="new_page.php?subject=<?php echo urlencode($current_subject["id"]);?>" method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="" />
      </p>
      <p>Position:
        <select name="position">
          <?php
          $page_set= find_pages($current_subject["id"]);
              $page_count = mysqli_num_rows($page_set); // for counting the rows in the table
            $count=$page_count+1;
          //for ($count=1; $count <=$page_count+1 ; $count++) {  
              echo "<option value =\"{$count}\">{$count}</option>";         // }
          ?>
        
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" /> No
        &nbsp;
        <input type="radio" name="visible" value="1" /> Yes
      </p>
      <p>
        Content: <br />
        <textarea  name="content" rows="20" cols="80"></textarea>
      </p>
      <input type="submit" name="submit" value="Create page" />
    </form>
    <br />
    <a href="manage_content.php?subject=<?php echo urlencode($current_subject["id"]);?>">Cancel</a>   
  </div>
</div>
		<?php	// Release the return data is in functions.php ?>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

		