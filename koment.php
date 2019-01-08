<?php
header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");


define("koment_semafor",3333);
$BASE_PATH = ".";

function createKoment($commentPath, $reaction, $user, $comment)
{
    mkdir($commentPath);

    //tu semafor
    $semafor=sem_get(koment_semafor);
    sem_acquire($semafor);
    $i = count(glob("$commentPath/*"));




    $commentFile = fopen("$commentPath/$i", "w");

    fwrite($commentFile, "$reaction\n");
    $date = date_format(date_create(), "Y-m-d, H:i:s");;
    fwrite($commentFile, "$date\n");
    fwrite($commentFile, "$user\n");
    fwrite($commentFile, "$comment\n");

    fclose($commentFile);
    sem_release($semafor);
}


$user = $_POST["user"];
$comment = $_POST["commententry"];
$reaction = $_POST["reaction"];
$blogname = $_GET["blogname"];
$entry = $_GET["entry"];
if (!(isset($user) and isset($comment) and
    isset($reaction) and
    isset($_GET["blogname"])and
    isset($_GET["entry"])and
    mb_ereg_match("pozytywny|neutralny|negatywny", $reaction))) {
    header("Location: dodajKomentarz.php?blogname=$blogname&entry=$entry&err=blad");
    return;
}

$blogname = htmlspecialchars_decode($_GET["blogname"]);
$entry = htmlspecialchars_decode($_GET["entry"]);



$commentPath = "$BASE_PATH/$blogname/$entry.k";


createKoment($commentPath, $reaction, $user, $comment);



header("Location: blog.php?nazwa=$blogname");
?>
