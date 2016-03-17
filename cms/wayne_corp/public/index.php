<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	// calling func to check whether page and subject are set
    find_selected_page(true);
?>
 <?php $layer_context = "public"; ?>
<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
		<div id="main">
  <div id="navigation">
    
  	<?php echo  public_navigation($current_subject,$current_page); // passing the assoc  array current of pages and subjects ?>
   
   

  </div>
  <div id="page">
      
     <?php if ($current_page) { ?>
     <h2><?php echo htmlentities($current_page["menu_name"]); ?></h2>
        <?php echo nl2br(htmlentities($current_page["content"]));?>
      
      <br />
    
     
      
   <?php }else{ ?>
          <?php if (isset($current_subject) && $current_page ==null) {
                echo "No pages to display";
          ?>
          <?php }else{?>
            <p>Welcome <?php echo htmlentities($_SESSION["username"]); ?></p>
            <?php }?>
     <?php }?>
     
     
     
  </div>
</div>
		<?php	// Release the return data is in functions.php?>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

		