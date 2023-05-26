<?php
require "vendor/autoload.php";
use League\Csv\Reader;
use League\Csv\Statement;

//load the CSV document from a stream
$stream = fopen('hotel.csv', 'r');
$csv = Reader::createFromStream($stream);
$csv->setDelimiter(';');
$csv->setHeaderOffset(0);

//build a statement
$header = $csv->getHeader(); //returns the CSV header record
$records = $csv->getRecords(); //returns all the CSV records as an Iterator object  
    
//query your records from the document
//$records = $stmt->process($csv);
//print_r ($records);

$conn =mysqli_connect('localhost','root','root','ripasso');
//fine connessione
foreach ($records as $indice => $record) {
    $dem=  mb_convert_encoding($record['Denominazione'], 'ISO-8859-1', 'UTF-8');
    $indirizzo = mb_convert_encoding($record['Indirizzo'], 'ISO-8859-1', 'UTF-8');
//echo $indirizzo;
//echo $record['Denominazione']." (".$record['Provincia'].") - ".$record['Sito internet']."- ".$record['Comune']."-".$record['Indirizzo']."-".$record['Posta elettronica']."\n";

$strSQL="INSERT into struttureRicettive (nome_struttura, provincia, sito_web , email, telefono) VALUES ('" .$dem. '\',\'' .$record['Provincia'] . '\',\''  .$record['Sito internet'] . '\',\''  .$record['Posta elettronica'] . '\',\'' .$record['Telefono'] . "')";
//echo $strSQL;
$query = mysqli_query($conn, $strSQL);
}
?>

