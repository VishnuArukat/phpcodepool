<?php 
	class strmatch{

		// Variables
		protected $str1;
		protected $str2;
		protected $array1;
		protected $array2;
		public $flag=true;
		// Occurance match
		public function occurance($ch){
				if (substr_count($this -> str1,$ch) == substr_count($this -> str2,$ch)) {
					return true;
				}
			}

		//Main function 

		public function eval_str($str1,$str2){
			$this -> str1 = trim($str1);
			$this -> str2 = trim($str2);

			if (strlen($this-> str1) == strlen($this -> str2)) {
				# code...
				$this -> array1 = str_split(trim($str1));
				foreach ($this -> array1 as $key) {
					# code...
					if ($this -> occurance($key) == false){
						$this -> flag = false;
						break;
					}
				}
			} else {
				# code...
				$this -> flag = false;
			}

	}
}
 ?>
 <?php 
 $check = new strmatch();
 $check -> eval_str("foobar", "barfoo");
 	if ($check ->  flag == false) {
 		# code...
 		echo "The strings are not equal";
 	}else{
 		echo " The given string have same length and also have the same number of character occurance";
 	}
  ?>
