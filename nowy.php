<?php
//header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");


define ("nowy_semafor",1155);
$BASE_PATH = ".";
function readFromInfo($infoPath, $short = True)
{
    $infoFile = fopen("$infoPath/info", "r");
    $user = rtrim(fgets($infoFile)); //rtrim usuwa białe znaki z prawej strony
    $info["user"] = $user;
    $password = rtrim(fgets($infoFile));
    $info["password"] = $password;
    $desc = "";

    if (!$short) {
        while (false !== ($line = fgets($infoFile))) {
            $desc .= $line;
        }
    }
    $info["desc"] = $desc;
    return $info;
}

function getBlogPathIfExist($BASE_PATH, $user, $password)
{
    $dir = opendir($BASE_PATH);
    while (false !== ($blogname = readdir($dir))) {
        if ($blogname == "." or $blogname == "..")
            continue;

        if (is_dir("$BASE_PATH/$blogname")) {
            $info = readFromInfo("$BASE_PATH/$blogname");
            $pass = $info["password"];
            $usr = $info["user"];

            if ($usr === $user and $pass === $password) {
                closedir($dir);
                return "$BASE_PATH/$blogname";
            }

        }
    }
    closedir($dir);
    return false;
}



function createInfoFile($path, $user, $password, $desc)
{
   // echo "$path/info";
    $info = fopen("$path/info", "w");
    fwrite($info, "$user\n");
    $password = md5($password);
    fwrite($info, "$password\n");
    fwrite($info, "$desc");
    fclose($info);
}





$blogname = $_POST["blogname"];
$blogdesc = $_POST["blogdesc"];
$user = $_POST["user"];
$password = $_POST["password"];
$blogPath = getBlogPathIfExist($BASE_PATH,$user,md5($password)) !==false;



if ((isset($_POST["password"]) and isset($_POST["user"]) and
    isset($_POST["blogname"]) and isset($_POST["blogdesc"]) and !$blogPath))
{
   // echo "cos";
    $semafor = sem_get(nowy_semafor);
    //echo "cospomiedzy";
    sem_acquire($semafor);
    //echo "cos1";

    if (mkdir("$BASE_PATH/$blogname")) {
        createInfoFile("$BASE_PATH/$blogname", $user, $password, $blogdesc);
        header("Location: blog.php?nazwa=$blogname");
        sem_release($semafor);
       // echo "cos2";
        return;

    }else{header("Location: stworzBloga.php?err=zajete");}


    sem_release($semafor);
    return;
    //echo "cos3";
}

header("Location: stworzBloga.php");


?>