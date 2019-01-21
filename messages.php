<?php
/**
 * Created by PhpStorm.
 * User: Joanna
 * Date: 12.01.2019
 * Time: 19:05
 */




//if (!file_exists($filename)) {
//    $file = fopen($filename, "w");
//    fwrite($file, "Napisz wiadomość, aby rozpocząć czat\n");
//    fclose($file);
//} else {
//    $file = fopen($filename, "r");
//    $text = fread($file, filesize($filename));
//    fclose($file);
//    echo $text;
//}

//$client_timestamp = intval($_GET["client_timestamp"]); // wersja klienta

// Disable max runtime
set_time_limit(0);
function poll($cur_line)
{
    $filename = "messages.txt";

    $client_timestamp = intval($_GET["client_timepstamp"]); // wersja klienta
   //echo $client_timestamp;
    // An infinite loop
    while (true) {
        $timestamp = filemtime($filename);
        if ($client_timestamp < $timestamp) {
            // Read the file
            $data = file_get_contents('messages.txt');
            $lines = explode("\n", $data);
            $ret = array();
            $ret['lines'] = array();
            // Put new lines in the vector
            for ($cur_line=0; $cur_line < count($lines)-1; $cur_line++) {
                $ret['lines'][] = $lines[$cur_line];
            }
            // Update the cur_line to response
            $ret['timestamp'] = $timestamp;
            // Return an JSON
            return json_encode($ret);
        } else {
            // Sleep for 1 seconds if no new line
            sleep(1);
            clearstatcache(True,$filename);
        }
    }
}
// echo the result
echo poll($_POST['cur_line']);

?>
