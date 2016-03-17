<?php
	if (!isset($layer_context)) {
		$layer_context = "admin";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
			<title>
				Wayne Industries Limited <?php if ($layer_context== "admin"){ echo "Admin";}?> 

			</title>
			

	<link rel="stylesheet" type="text/css" href="css/public.css"> <!-- adding css file !-->
	</head>
	<body>
		<div id = "header" style = "background:#323538">
			<?php if ($layer_context== "admin") {?>
				<h1><a href="admin.php" style="text-decoration:none;padding-left:50%;" >Wayne Corp Admin </a></h1>
				<?php }else{ ?>
					<h1><a href="index.php" style="text-decoration:none;padding-left:50%;" hover="none">Wayne Corp </a></h1>
				<h4 align="right"><a href="logout.php" id="hide">logout</a></h4>
		<?php	
			}?>
	<?php	
		?>
		</div>