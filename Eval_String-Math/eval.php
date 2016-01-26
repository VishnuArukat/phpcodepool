<?php
function arithmetic($expression)
{
	$temp = preg_replace('([^\\+\\-*\\/%\\^])', ' ', trim($expression));
	$temp = explode(' ', trim($temp));
	
	foreach ($temp as $key => $val)
	{
		if ($val)
			$operators[] = $val;
	}
	
	$numbers = preg_replace('([^0-9])', ' ', trim($expression));
	$numbers = explode(' ', $numbers);
	
	$i = 0;
	
	foreach ($numbers AS $key => $val)
	{
		if ($key == 0)
		{
			$answer = $val;
			continue;
		}
	
		if ($val)
		{
			switch ($operators[$i])
			{
				case '+':
					$answer += $val;
					break;
					
				case '-':
					$answer -= $val;
					break;
					
				case '*':
					$answer *= $val;
					break;
					
				case '/':
					$answer /= $val;
					break;
					
				case '^':
					$answer ^= $val;
					break;
					
				case '%':
					$answer %= $val;
			}
			
			$i++;
		}
	}
	
echo "The answer to the math expression is : ".$answer;
} 
	$result = arithmetic("5+4-6+2");
?>
