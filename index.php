<style>
	.good{
		color:green;
		font-weight: 600;
	}

	.err{
		color:red;
		font-weight: 600;
	}
</style>


<?php
header('Content-Type: text/html; charset=CP852');
//header("Content-Type: text/html; charset=windows-1250");	
try{
	$lines = file('plik.csv');
	
	foreach ($lines as $line_num => $line) {
	    $fileContent[] = htmlspecialchars($line);
	}
	echo "<div class='good'>OK: Plik wczytany poprawnie.  </div>";
}catch (Exception $e) {
	echo "<div class='err'>ERR: Błąd podczas wczytywania pliku. </div>";
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    exit();
}


try{
	for ($i=0; $i <count($fileContent) ; $i++) { 
		$explode[]=explode(';', $fileContent[$i]);
	}
	echo "<div class='good'>OK: Konwersja pliku do tablicy zakończona pomyślnie.  </div>";
}catch (Exception $e) {
	echo "<div class='err'>ERR: Błąd podczas konwersji pliku na tablicę</div>";
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    exit();
}

// echo "<pre>";
// var_dump($explode);
// echo "</pre>";
// exit();


$begining = '[INFO]
"1.05",3,1250,"Subiekt GT","Elkomp","Elkomp 2016","Elkomp Jacek Kądziołka","Limanowa","34-600","Krótka  12","737-175-79-65","1","Sklep ul. Krótka 12",,,1,20160311114455,20160311114455,"Śliwa  Dawid",20160311114456,"Polska","PL","PL 7371757965",1

[NAGLOWEK]
"FZ",,,,,,,,,,,"9451981163","TOPTEL ANNA I WIKTOR WOŁKOWICZ SPÓŁKA JA","TOPTEL ANNA I WIKTOR WO£KOWICZ SPÓŁKA JAWNA","Kraków","31-221","Białoprądnicka 15A","9451981163","Zakup","Zakup towarów lub usług","Kraków",20160309000000,20160309000000,20160309000000,30,1,"Cena ostatniej dost.",,,,,,,,,,,0,0,1,3,,,,0.0000,0.0000,"PLN",1.0000,,,,,0,0,0,,0.0000,,0.0000,"Polska","PL",0

[ZAWARTOSC]';



$firstContent = '';
$secondContent = '';

try{
	for ($i=1; $i < count($explode) ; $i++) { 
		//$code = str_replace("\n\r", "",$explode[$i][6]);
		$code = str_replace(array("\r", "\n"), '', $explode[$i][6]);
		$firstContent .= '
'.$i.',1,"'.$code.'",1,0,0,1,0.0000,0.0000,"szt",'.$explode[$i][1].','.$explode[$i][1].','.$explode[$i][2].',,,23.0000,,,,,,';

		$secondContent .= '
1,"'.$code.'",,"'.$code.'","'.$explode[$i][0].'","'.$explode[$i][0].'","'.$explode[$i][0].'",,,"szt.","23",0,"23",0,0,0.0000,"szt.",0,"PLN",,,0.0000,0,,,0,"szt.",0.0000,0.0000,,0,,0,0,,,,,,,,';
	}
	echo "<div class='good'>OK: Dane zostały poprawnie przetworzone.  </div>";
}catch (Exception $e) {
	echo "<div class='err'>ERR: Błąd podczas przetwarzania danych. </div>";
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    exit();
}



$litleContent ='

[NAGLOWEK]
"TOWARY"

[ZAWARTOSC]';


$fullContent = $begining.$firstContent.$litleContent.$secondContent."\n";
//$fullContent = iconv(mb_detect_encoding($fullContent), "ISO-8859-2//TRANSLIT", $fullContent);

//$fullContent = htmlentities($fullContent, ENT_COMPAT, "CP852");

try {
	$fp = fopen("plik.epp", "w");
	fputs($fp, $fullContent);
	fclose($fp);
	echo "<div class='good'>OK: Plik został poprawnie zapisany.  </div>";
} catch (Exception $e) {
	echo "<div class='err'>ERR: Błąd podczas zapisu danych do pliku. </div>";
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    exit();
}

?>

