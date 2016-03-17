<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php
	// calling func to check whether page and subject are set
    find_selected_page();?>
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
    // outputing the message 
    echo session_message();
    ?>
    <?php $errors = session_errors(); ?>
    <?php echo form_errors($errors); ?>
      <h2>Create Subject</h2>

    <form action="create_subject.php" method="post">
      <p>Menu name:
        <input type="text" name="menu_name" value="" />
      </p>
      <p>Position:
        <select name="position">
          <?php
          $subject_set= find_subjects();
              $subject_count = mysqli_num_rows($subject_set); // for counting the rows in the table
          for ($count=1; $count <=$subject_count+1 ; $count++) {  
              echo "<option value =\"{$count}\">{$count}</option>";          }
          ?>
        
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" /> No
        &nbsp;
        <input type="radio" name="visible" value="1" /> Yes
      </p>
      <input type="submit" name="submit" value="Create Subject" />
    </form>
    <br />
    <a href="manage_content.php">Cancel</a>  
    
     
     
  </div>
</div>
		<?php	// Release the return data is in functions.php ?>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

		