<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>

 <?php $admin_set= find_all_admins(); ?>
 <?php $layer_context = "admin"; ?>
<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
		<div id="main">
  
  <div id="navigation">
    &nbsp;
    <br />
    <a href="admin.php"> &laquo; Main Menu </a>
  </div>

<div id="page">
  <?php echo session_message(); ?>
 <h2>Mangae Admins</h2>
 <table>
   <tr>
      <th style="text-align: left; width: 200px;">Username</th> 
      <th colspan="2" style="text-align: left;">Actions</th>
   </tr>
   <?php while($admin=mysqli_fetch_assoc($admin_set)){ ?>
<tr>
  <td><?php echo htmlentities($admin["username"]) ; ?></td>
  <td><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>">Edit</a></td>
  <td><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick ="return confirm('Are You sure ?');">Delete</a></td>
</tr>
<?php } ?>
 </table>
  <br />
  <br />
  <a href="new_admin.php">Add New user</a>
  <hr>

    <?php 
      // testing password hashing
    //  $pass = "pass1";
    //  $hash_format ="$2y$10$"; #use blowfish and run it 10 times
    //  $salt="Salt22CharactersOrMore";
    //  echo "Length :".strlen($salt);
    //  $format_and_salt =$hash_format.$salt;
    //  $hash=crypt($pass,$format_and_salt); echo "<br />";
    //  echo $hash;
    //  echo "<br />";
    //  $hash2=crypt("pass1",$hash);
    //  echo $hash2;
   ?>
 </div>  
</div>
	
  	<?php	// Release the return data is in functions.php?>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>

		