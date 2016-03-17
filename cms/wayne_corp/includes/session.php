<?php
session_start();


function session_message(){
 if (isset($_SESSION["message"])) {
      $output = "<div class=\"message\">";
      $output .= htmlentities($_SESSION["message"]);
      $output .= "</div>";
      // clearing after one time
      $_SESSION["message"] = null; 

      return $output;
    }
}

function session_errors(){
  if (isset($_SESSION["errors"])) { 
      $errors = $_SESSION["errors"]; 
      // clearing after one time
      $_SESSION["errors"] = null; 

      return $errors;
    }	
}

?>