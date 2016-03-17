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
header('Content-Type: text/html; charset=utf-8');
	
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



$begining = '[INFO]
"1.05",3,1250,"Subiekt GT","Elkomp","Elkomp 2016","Elkomp Jacek K¹dzio³ka","Limanowa","34-600","Krótka  12","737-175-79-65","1","Sklep ul. Krótka 12",,,1,20160311114455,20160311114455,"Œliwa  Dawid",20160311114456,"Polska","PL","PL 7371757965",1

[NAGLOWEK]
"FZ",,,,,,,,,,,"9451981163","TOPTEL ANNA I WIKTOR WO£KOWICZ SPÓ£KA JA","TOPTEL ANNA I WIKTOR WO£KOWICZ SPÓ£KA JAWNA","Kraków","31-221","Bia³opr¹dnicka 15A","9451981163","Zakup","Zakup towarów lub us³ug","Kraków",20160309000000,20160309000000,20160309000000,30,1,"Cena ostatniej dost.",,,,,,,,,,,0,0,1,3,,,,0.0000,0.0000,"PLN",1.0000,,,,,0,0,0,,0.0000,,0.0000,"Polska","PL",0

[ZAWARTOSC]';



$firstContent = '';
$secondContent = '';

try{
	for ($i=1; $i < count($explode) ; $i++) { 
		$code = str_replace("\n", "",$explode[$i][6]);
		
		$firstContent .= '
'.$i.',1,'.$code.',1,0,0,0,0.0000,0.0000,"szt.",'.$explode[$i][1].',,,'.$explode[$i][2].',,23.0000,,,,,,';

		$secondContent .= '
1,"'.$code.'",,"'.$code.'","'.$explode[$i][0].'",,"'.$explode[$i][0].'"';
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


$fullContent = $begining.$firstContent.$litleContent.$secondContent;


try {
	$fp = fopen("plik.txt", "w");
	fputs($fp, $fullContent);
	fclose($fp);
	echo "<div class='good'>OK: Plik został poprawnie zapisany.  </div>";
} catch (Exception $e) {
	echo "<div class='err'>ERR: Błąd podczas zapisu danych do pliku. </div>";
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    exit();
}

?>

