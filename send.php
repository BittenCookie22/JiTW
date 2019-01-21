<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 12.01.2019
 * Time: 19:04
 */

$filename = "messages.txt";
$file = fopen($filename, "a");
$count = count(file($filename));
$text = $_GET["nick"].": ".$_GET["message"]."\n";
fwrite($file, $text);
fclose($file);

if ($count == 5) { // max 5 wiadomosci w pliku
    $file = file($filename);
    unset($file[0]);
    file_put_contents($filename, $file);
}
?>
