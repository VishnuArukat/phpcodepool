<?php
	//turn on the output buffering	
	function redirect_to($new_location){
		header("Location: ". $new_location);
		exit();
	}
	function mysql_prep($string){
		global $connection;
		$escaped_string = mysqli_real_escape_string($connection,$string);
		return trim($escaped_string);
	}

	

	function confirm_query($result){

		if (!$result) {
			die("Database query failed ");
		}
	}
	
	function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>";
	    $output .= htmlentities($error);
	    $output .="</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}

	function find_all_admins(){
		global $connection;
		$query = "SELECT * FROM admins ";
		$query .="ORDER BY username ASC";
		$result= mysqli_query($connection,$query);
		confirm_query($result);
		return $result;


	}
	function find_admin_by_id($id){
		global $connection;
		global $current_admin;
		$safe_admin_id = mysqli_real_escape_string($connection, $id);
		$query="SELECT * FROM admins ";
		$query .="WHERE id={$safe_admin_id} ";
		$query .= "LIMIT 1";
		$result=mysqli_query($connection,$query);
		confirm_query($result);
		$current_admin= mysqli_fetch_assoc($result);
		return $result;
	}
	
	function password_encryption($password){
		$hash_format="$2y$10$";
		$salt_length=22;
		$salt = generate_salt($salt_length);
		$format_and_salt=$hash_format.$salt;
		$hash= crypt($password,$format_and_salt);
		return $hash;
	}

	function generate_salt($len){
		#not 100% for unique and not 100% random but good for salt
		# md5 returns 32 charaters
		$unique_random_string=md5(uniqid(mt_rand(),true));

		// valid characters for salt are [aA-zZ-0-9./]
		$base64_string =base64_encode($unique_random_string);

		//but not '+' which is valid in base64 encoding
		$modified_base64_string=str_replace('+','.',$base64_string);

		//truncate string to the correct length
		$salt= substr($modified_base64_string,0,$len);
		return $salt;
	}

	function password_check($password,$existing_hash){

		$hash = crypt($password,$existing_hash);
		if ($hash===$existing_hash) {
			return true;
		}else{

			return false;
		}

	}

	function admin_by_username($username){
		global $connection;
		$safe_username=mysqli_real_escape_string($connection,$username);
		$query= "SELECT hashed_password FROM admins ";
		$query .="WHERE username='{$safe_username}' ";
		$query .="LIMIT 1";
		$result=mysqli_query($connection,$query);
		confirm_query($result);
		if ($user=mysqli_fetch_assoc($result)) {
			return $user;
		}else{
			return null;	
		}
		
	}
	

	function attempt_login($username,$password){
			// attempt to login
		$user=admin_by_username($username);
		if ($user) {
			//we found admin
			//password checking
			if(password_check($password,$user["hashed_password"])){
				return $user;	
			}else{
				//password do not match
				return false;
			}
			
		}else{
			//no return false
			return false;
		}

	}
	function logged_in(){
		return isset($_SESSION["username"]);
	} 


	function confirm_logged_in(){

		if (!logged_in()) {
			redirect_to("login.php");
		}
	}


	function find_subjects($public=true){
		global $connection;

		// 2. perform query
		// function for subjects
		$query = "SELECT *  FROM SUBJECTS ";
		if ($public==true) {
			$query .="WHERE visible=1 ";
		}
		$query .= "ORDER BY position "; // query as a variable
		// $query .= "WHERE visible = 1";
		$result = mysqli_query($connection,$query); // return as a resource not array
		// test if there was an error
		confirm_query($result);
		return $result;
	}

	function find_pages($subject_id,$public=true){
					global $connection; // setting connection as a global
		// function for pages
		// 2. perform query for pages
					// must be inside the first loop
					// query can be reused but not the result 
					$safe_subject_id=mysqli_real_escape_string($connection,$subject_id);
					$query  = "SELECT *  FROM PAGES "; // query as a variable
				//	$query .="WHERE visible =1 ";
					$query .= "WHERE subject_id= {$safe_subject_id} ";
					if ($public==true) {
						$query .="AND visible =1 ";
					}
					$query .= "ORDER BY position ASC";

					$result_page  = mysqli_query($connection,$query); // return as a resource not array
					// test if there was an error
					confirm_query($result_page);
					return $result_page;
	}

	function find_subject_by_id($subject_id,$public=true){

		global $connection;

		// 2. perform query
		// function for subjects
		$safe_subject_id=mysqli_real_escape_string($connection,$subject_id);// bcoz we are getting the values from the GETT values so possibilty of sql injection
		$query = "SELECT *  FROM SUBJECTS "; // query as a variable
		$query .= "WHERE id = {$safe_subject_id} ";
		if ($public) {
			$query .= "AND visible=1 ";
		}
		$query .= "LIMIT 1";
		$result = mysqli_query($connection,$query); // return as a resource not array
		// test if there was an error
		confirm_query($result);
		if ($subject = mysqli_fetch_assoc($result)) {
			return $subject;
		}else {
			return null;
		}
		
	
	}
	function find_page_by_id($page_id,$public=true){
		// page_id is the get value from url
		global $connection;
		$safe_page_id=mysqli_real_escape_string($connection,$page_id);
		
		$query = "SELECT *  FROM PAGES "; // query as a variable
		$query .= "WHERE id = {$safe_page_id} ";
		if ($public) {
			$query .= "AND visible=1 ";
		}
		$query .= "LIMIT 1";
		$result = mysqli_query($connection,$query); // return as a resource not array
		// test if there was an error
		confirm_query($result);
		if ($page = mysqli_fetch_assoc($result)) {
			return $page;
		}else {
			return null;
		}
		

	}
	function default_page_for_subject($subject_id){

		$page_set= find_pages($subject_id);
		if ($first_page = mysqli_fetch_assoc($page_set)) {
			return $first_page;
		}else {
			return null;
		}
		

	}


	function find_selected_page($public=false){
		global $current_subject;
		global $current_page; //instead of returning we can make it as a global variable

		if (isset($_GET["subject"])) {
		$current_subject = find_subject_by_id($_GET["subject"],$public);
		if ($current_subject && $public) {
				$current_page = default_page_for_subject($current_subject["id"]); # default page for subject		}
			}else{			
				$current_page = null;
			}
		} elseif (isset($_GET["page"])) {
		$current_page = find_page_by_id($_GET["page"],$public); # for not displaying the invisible pages
		$current_subject = null;
		} else { # for coming from admin page
			$current_subject = null;
			$current_page = null;
		}
	}

	function navigatiion($subject_array,$page_array){
		// breaking the html to php 
		// we can use the global in case of selected_subject_id= now subject_id and viz page_id

		 $output="<ul class =\"subjects\">"; # for rendering the words 
		
		 $result_subject = find_subjects(false); 

			// Use data
		 	// $subject & $subjects are differnt

			while ($subjects = mysqli_fetch_assoc($result_subject)) { 
			# escaping the double quotes from mis understnd
			// echo "<li class =\"selected\" >"; breaking this to include if loop
			$output .= "<li";
			if ($subject_array && $subjects["id"]== $subject_array["id"]) { // checking the value is null and id is equal or not
				$output .=" class =\"selected\""; #space is needed in front
			}
			
			$output .= ">";  
			
			
			// ?subject= is  the GET variable to use  
			$output .="<a href=\"manage_content.php?subject=";
			$output .= urlencode($subjects["id"]);
			$output .="\">";
			$output .= htmlentities($subjects["menu_name"]);
			$output .="</a>";

		 	$result_page=find_pages($subjects["id"],false);
			$output .="<ul class =\"pages\">";  
			// Use page data
			while ($page = mysqli_fetch_assoc($result_page)) {		
			$output .= "<li";
			if ($page_array && $page["id"]== $page_array["id"]) { // checking the value is null and id is equal or not 
				$output .=  " class =\"selected\"";
			}
			
			$output .= ">";  
			
			$output .="<a href=\"manage_content.php?page=";
			$output.=  urlencode($page["id"]);
			$output .= "\">";
			$output .= htmlentities($page["menu_name"]) ;
			$output .= "</a>";  
			// placing the links
			$output .="</li>"; 
 				}
			
			// Release the page data
			mysqli_free_result ($result_page);
			$output .="</ul>";
			$output .="</li>";			
		// closing the while loop here 
			
			}
			// Release the subject data
			mysqli_free_result ($result_subject);

			$output .="</ul>"; 
			return $output;

	}
	function public_navigation($subject_array,$page_array){
		// for public area
		// breaking the html to php 
		// we can use the global in case of selected_subject_id= now subject_id and viz page_id

		 $output="<ul class =\"subjects\">"; # for rendering the words 
		
		 $result_subject = find_subjects(); 

			// Use data
		 	// $subject & $subjects are differnt

			while ($subjects = mysqli_fetch_assoc($result_subject)) { 
			# escaping the double quotes from mis understnd
			// echo "<li class =\"selected\" >"; breaking this to include if loop
			$output .= "<li";
			if ($subject_array && $subjects["id"]== $subject_array["id"]) { // checking the value is null and id is equal or not
				$output .=" class =\"selected\""; #space is needed in front
			}
			
			$output .= ">";  
			
			
			// ?subject= is  the GET variable to use  
			$output .="<a href=\"index.php?subject=";
			$output .= urlencode($subjects["id"]);
			$output .="\">";
			$output .= htmlentities($subjects["menu_name"]);
			$output .="</a>";

			if ($subject_array["id"]==$subjects["id"] || $page_array["subject_id"]==$subjects["id"]) {

			$result_page=find_pages($subjects["id"]);
			$output .="<ul class =\"pages\">";  
			// Use page data
			while ($page = mysqli_fetch_assoc($result_page)) {		
			$output .= "<li";
			if ($page_array && $page["id"]== $page_array["id"]) { // checking the value is null and id is equal or not 
				$output .=  " class =\"selected\"";
			}
			
			$output .= ">";  
			
			$output .="<a href=\"index.php?page=";
			$output.=  urlencode($page["id"]);
			$output .= "\">";
			$output .= htmlentities($page["menu_name"]) ;
			$output .= "</a>";  
			// placing the links
			$output .="</li>"; 
 				}
			
			// Release the page data
			mysqli_free_result ($result_page);
			$output .="</ul>";
				
			}

		 	
			$output .="</li>";
			// end of subject li			
		// closing the while loop here 
			
			}
			// Release the subject data
			mysqli_free_result ($result_subject);

			$output .="</ul>"; 
			return $output;

	

	}

?>