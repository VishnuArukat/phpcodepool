<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php
	// calling func to check whether page and subject are set
    find_selected_page();
?>
 <?php $layer_context = "admin"; ?>
<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
		<div id="main">
  <div id="navigation">
    <br />
    <a href="admin.php">&laquo; Main Menu</a><br />
    
  	<?php echo  navigatiion($current_subject,$current_page); // passing the assoc  array current of pages and subjects ?>
    <br />
    <a href="new_subject.php">+ Add a subject</a>

  </div>
  <div id="page">
        <?php
    // outputing the message 
    echo session_message();
    ?>
      
     <?php if ($current_subject) { ?>
     <h2>Manage Subject</h2>
    Menu Name : <?php	echo htmlentities($current_subject["menu_name"]);  // getting from above ?> <br />
    Position : <?php  echo $current_subject["position"]; ?> <br />
    Visible : <?php  echo $current_subject["visible"] ==1 ? 'Yes' : 'No'; ?> <br />
    <a href ="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>">Edit Subject </a>
    <br />
    <br />
    <br />
    <ul>
    <div style="margin-top: 2em; border-top: 1px solid #000000;"> 
    <h3>Pages In this Subject</h3>
   
  
    <?php

      $pagesin=find_pages($current_subject["id"]);
      if (mysqli_num_rows($pagesin)==0){ 
        echo  "No pages to display.";
         
      }else{
      while($row=mysqli_fetch_assoc($pagesin)){ ?>
   <li>
      <a href="manage_content.php?page=<?php echo urlencode($row["id"]);?>"> <?php echo $row["menu_name"] . "<br />";?>
   </li>
    <?php  
    }
  }
    ?>  
  <br />
  <br />
  <a href = "new_page.php?subject=<?php echo urlencode($current_subject["id"]); // current_subject gets the value from GET ?>">+ Add new page to <?php echo $current_subject["menu_name"]; ?> </a>
    </ul>
    </div>


     <?php } elseif ($current_page) { ?>
     <h2>Manage Pages</h2>
     Menu Name : <?php  echo htmlentities($current_page["menu_name"]);?>	<br /> 
     Position : <?php  echo $current_page["position"]; ?> <br />
     Visible : <?php  echo $current_page["visible"] ==1 ? 'Yes' : 'No'; ?> <br />
     Content <br />
     <div class= "view-content">
        <?php echo nl2br(htmlentities($current_page["content"])); # nl2br() convert newline in html to br?>
      </div>
      <br />
      <br />
      <a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit <?php echo htmlentities($current_page["menu_name"]);?></a>
     <?php } else{ ?>
     <center>Please Select the Path You Want To Travel</center>
     <?php }?>
     
     
  </div>
</div>
		<?php	// Release the return data is in functions.php?>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

		