<!DOCTYPE HTML>	
<html lang = "pl">
<head>
	<meta charset="utf-8"/>
	<title>Form in PHP</title>
</head>

	<body>
		<?php
	 	$wzorzec=$_POST['wzorzec'];
		
		function makeRegexfromWzorzec($wzorzec){
			$output = "";
			for($i=0;$i<strlen($wzorzec);$i++){	
				if($wzorzec[$i]=="_") {$output= $output.".";}
				else{$output= $output.$wzorzec[$i];}
				 }
			//echo $output;
			return $output;			
		}
		$output = makeRegexfromWzorzec($wzorzec);
		$regex = "/^".makeRegexfromWzorzec($wzorzec)."\$/";
		echo "Wpisany wzorzec: $output"; 
		echo "<br/>";
		echo "<br/>";
		echo "Wszystkie słowa:";
		echo "<br/>";	
	$plik = fopen("baza.txt", "r");
	$counter=0;
	while (!feof($plik)) {
  		$s = fgets($plik);
  		echo $s."<br/>";
	}
	fclose($plik);


		echo "<br/>";
		echo "Dopasowane słowa";
		echo "<br/>";
		
		$plik1=fopen("baza.txt","r");
		$counter=0;
		while (!feof($plik1)) {
			$str=fgets($plik1);
			$tmp = trim($str);
	                if(preg_match($regex,$tmp)){
                              echo $tmp."<br/>";
                              $counter=$counter+1;}


		}
		echo "Ilość dopasowań: $counter";
		echo "<br/>";
                if($counter==0){echo "Brak dopasowań!";}
		fclose($plik1);
		?>
		

	</body>

</html>
