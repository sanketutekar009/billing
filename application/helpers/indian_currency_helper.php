<?php 
	function convert_indian_currency($num){
		if(strlen($num) < 4){
			return $num;
		}else{
			if(stristr($num,'.')){
				$explode_no = explode('.',str_ireplace(',','',$num));
				$tail = substr($explode_no['0'],-3);
				$head = substr($explode_no['0'],0,-3);
				$head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/",",",$head);
				return trim($head.",".$tail.".".$explode_no['1'],',');
			}else if(stristr($num,'-')){
				$num = trim(str_ireplace(',','',$num),'-');
				
				$tail = substr($num,-3);
				$head = substr($num,0,-3);
				$head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/",",",$head);
				return '-'.trim($head.",".$tail,',');
			}else{
				$tail = substr($num,-3);
				$head = substr($num,0,-3);
				$head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/",",",$head);
				return trim($head.",".$tail,',');
			}
		}
	}
?>
