<?php
// header("content-type:application/xhtml+xml; charset =utf-8","application/xhtml+xml; charset =utf-8");

define ("wpis_semafor",2222);
$BASE_PATH = ".";
//function fileCounter($files)
//{
//    $file_count = count($files["name"]);
//   // $j = 0;
//    for ($i = 0, $j = 0; $i < $file_count; $i++) {
//        if ($files["error"][$i] == 0) {
//            $j++;
//        }
//    }
//    return $j;
//
//}

function getBlogIfExist($BASE_PATH, $user, $password)
{
    $dir = opendir($BASE_PATH);
    while (false !== ($blogname = readdir($dir))) {
        if ($blogname == "." or $blogname == "..")
            continue;

        if (is_dir("$BASE_PATH/$blogname")) {
            $info = readFromInfoFile("$BASE_PATH/$blogname");
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


function readFromInfoFile($infoPath, $short = True)
{
    $infoFile = fopen("$infoPath/info", "r");
    $user = rtrim(fgets($infoFile));
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

function currDate($time)
{
    return date_create_from_format("Y-m-d H:i", $time);
}



function generateName($date, $blogpath)
{

    $seconds = date_format(date_create(), "s");
    $prefix = date_format($date, "YmdHi");
    do{
        $unique = rand(10, 99);
        $name="$prefix$seconds$unique";
    }while(file_exists("$blogpath/$name"));

    return $name;
}

function createWpis($path, $name, $data)
{
    $post = fopen("$path/$name", "w");
    fwrite($post, $data["blogentry"]);
    fclose($post);

    setlocale(LC_ALL, 'en_US.UTF-8');
    if ($data["files"] !== null) {
        $file_count = count($data["files"]["name"]);

        for ($i = 0, $j = 0; $i < $file_count; $i++) {
            if ($data["files"]["error"][$i] == 0) {
                $rozszerzeniePliku = pathinfo($data["files"]["name"][$i], PATHINFO_EXTENSION);
                move_uploaded_file($data["files"]["tmp_name"][$i], "$path/$name$j.$rozszerzeniePliku");
                $j++;
            }
        }

    }
}

$semafor = sem_get(wpis_semafor);


$user = $_POST["user"];
$password = $_POST["password"];
$blogPath = getBlogIfExist($BASE_PATH,$user,md5($password));



$date = $_POST["date"];
$time = $_POST["time"];

$data["blogentry"]=$_POST["blogentry"];
$data["files"]=$_FILES["files"];

if(
!(
    isset($user)and
    isset($password)and
    ($blogPath!==false) and
    isset($date) and
    isset($time) and
    isset($data["blogentry"]) and
   // (fileCounter($data["files"])<=3)and
    mb_ereg_match("[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}","$date $time")
)
){
//    echo $user;
//    echo $password;
//    echo $date;
//    echo $time;
//    echo $data;
//    echo     mb_ereg_match("[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}","$date $time")
// ?"tru":"f";
    header("Location: dodajWpis.php?err=blad");
    return;
}
sem_acquire($semafor);
createWpis($blogPath,generateName(currDate("$date $time"),$blogPath),$data);
sem_release($semafor);

$blogname=basename($blogPath);
header("Location: blog.php?nazwa=$blogname");
?>
