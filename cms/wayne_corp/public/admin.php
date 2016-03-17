<?php require_once ("../includes/session.php"); ?>
<?php require_once ("../includes/functions.php"); ?>
<?php require_once ("../includes/dbconnect.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layer_context = "admin"; ?>
<?php include "../includes/layouts/header.php"; #.. for going back directory ?>
		<div id="main" style= "background:#DCDAD3">
  <div id="navigation" style= "background:#DED5DA">
    &nbsp;
  </div>
  <div id="page" style= "background:#D4D1C6">
    <h2>Admin Menu</h2>
    <p>Welcome to the admin area. </p>
    <ul>
      <li><a href="manage_content.php">Manage Website Content</a></li>
      <li><a href="manage_admins.php">Manage Admin Users</a></li>
      <li><a href="logout.php">Logout</a></li>

    </ul>
  </div>
</div>
<?php include "../includes/layouts/footer.php"; #.. for going back directory ?>