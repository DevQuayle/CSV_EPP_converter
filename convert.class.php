<?php

header('Content-Type: text/html; charset=UTF-8');
//header("Content-Type: text/html; charset=windows-1250");


function win2utf(){
  $tabela = Array(
    "\xb9" => "\xc4\x85", "\xa5" => "\xc4\x84", "\xe6" => "\xc4\x87", "\xc6" => "\xc4\x86",
    "\xea" => "\xc4\x99", "\xca" => "\xc4\x98", "\xb3" => "\xc5\x82", "\xa3" => "\xc5\x81",
    "\xf3" => "\xc3\xb3", "\xd3" => "\xc3\x93", "\x9c" => "\xc5\x9b", "\x8c" => "\xc5\x9a",
    "\x9f" => "\xc5\xba", "\xaf" => "\xc5\xbb", "\xbf" => "\xc5\xbc", "\xac" => "\xc5\xb9",
    "\xf1" => "\xc5\x84", "\xd1" => "\xc5\x83", "\x8f" => "\xc5\xb9");
   return $tabela;
  }

  function UTF8_2_WIN1250($tekst){
   return strtr($tekst, array_flip(win2utf()));
  }


function convert( $filePath = 's', $output = 'o' ){

//    echo "<pre>";
//    print_r($filePath);
//    echo "</pre>";

    try{
        $lines = file($filePath);
        $lines = str_replace('"', '', $lines);

        if(!isset($lines))  throw new Exception('<div class="err">ERR: Błąd podczas wczytywania pliku. </div>');

        if(empty($lines))  throw new Exception('<div class="err">ERR: Plik jest pusty. </div>');

        foreach ($lines as $line_num => $line) {
            $fileContent[] = htmlspecialchars($line);
        }


        echo "<div class='good'>OK: Plik wczytany poprawnie.  </div>";
    }catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }


    try{

        for ($i=0; $i <count($fileContent) ; $i++) {

            $explode[]=explode(';', $fileContent[$i]);

        }
        if(!$explode) throw new Exception( "<div class='err'>ERR: Błąd podczas konwersji pliku na tablicę</div>");

        echo "<div class='good'>OK: Konwersja pliku do tablicy zakończona pomyślnie.  </div>";
    }catch (Exception $e) {
        echo  $e->getMessage();
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
       // exit();
        if ($firstContent == '' || $secondContent == '') throw new Exception("<div class='err'>ERR: Błąd podczas przetwarzania danych. </div>");
        echo "<div class='good'>OK: Dane zostały poprawnie przetworzone.  </div>";
    }catch (Exception $e) {
        echo $e->getMessage();
        exit();
    }



    $litleContent ='

    [NAGLOWEK]
    "TOWARY"

    [ZAWARTOSC]';

function csv_encode_conv($var, $enc='Windows-1252') {
$var = htmlentities($var, ENT_QUOTES, 'utf-8');
$var = html_entity_decode($var, ENT_QUOTES , $enc);
return $var;
}

    $fullContent = $begining.$firstContent.$litleContent.$secondContent."\n";

    $fullContent = UTF8_2_WIN1250($fullContent);

    //UNIX to DOS convert
    $fullContent = preg_replace('~(*BSR_ANYCRLF)\R~', "\r\n", $fullContent);


    try {
        $fp = fopen($output, "w");
        fputs($fp, $fullContent);
        fclose($fp);
        echo "<div class='good'>OK: Plik został poprawnie zapisany.  </div>";
    } catch (Exception $e) {
        echo "<div class='err'>ERR: Błąd podczas zapisu danych do pliku. </div>";
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        exit();
    }
}

?>
