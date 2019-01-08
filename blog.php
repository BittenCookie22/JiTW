<?php
header("content-type:application/xhtml+xml; charset =utf-8", "application/xhtml+xml; charset =utf-8");

$BASE_PATH = ".";

function readFromInfo($infoPath, $short = True)
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


function createHTMLPost($blogPath,$blogname, $entry)
{
    $data = getPost($blogPath, $entry);

    $Postentry = htmlspecialchars($data["entry"]);

    $year = $data["year"];
    $month = $data["month"];
    $day = $data["day"];
    $hour = $data["hour"];
    $minute = $data["minute"];
    $second = $data["second"];

    $date = "$year-$month-$day, $hour:$minute:$second";
    echo "<li class=\"post\">\n";
    echo "<div class=\"content\"><pre>$Postentry</pre><br/><span class=\"date\">$date</span></div>";
    echo "<ul class=\"files\">";
    foreach (glob("$blogPath/$entry{0,1,2,3}.*", GLOB_BRACE) as $file) {
        $filename = basename($file);
        echo "<li><a href=\"$file\">$filename</a></li>";
    }
    echo "</ul>\n";
    echo "<h2>Komentarze:</h2>\n";
    echo "<ul class=\"comments\">\n";

    $max=0;
    $comments = [];
    foreach (glob("$blogPath/$entry.k/*") as $file) {
        $id = intval(basename($file));
        $comments[$id] = $file;
        $max=$id+1;
    }
    for($id=0;$id<$max;$id+=1){
        if($comments[$id] !==null)
            createHTMLcomment($comments[$id]);
    }
    $urlblog=htmlspecialchars($blogname);
    $urlEntry=htmlspecialchars($entry);
    echo "<a href=\"dodajKomentarz.php?blogname=$urlblog&amp;entry=$urlEntry\" >Dodaj Komentarz</a>";
    echo "</ul>";
    echo "</li>\n";
}

function getPost($path, $name)
{
    $data["entry"] = "";
    $post = fopen("$path/$name", "r");
    while (($ext = fgets($post)) !== False)
        $data["entry"] .= $ext;
    fclose($post);
    $data["name"] = $name;
    $data["year"] = substr($name, 0, 4);
    $data["month"] = substr($name, 4, 2);
    $data["day"] = substr($name, 6, 2);
    $data["hour"] = substr($name, 8, 2);
    $data["minute"] = substr($name, 10, 2);
    $data["second"] = substr($name, 12, 2);
    $data["unique"] = substr($name, 14, 2);

    return $data;
}

function createHTMLcomment($commentPath)
{
    $comment = fopen($commentPath, "r");
    $reaction = htmlspecialchars(rtrim(fgets($comment)));
    $date = htmlspecialchars(rtrim(fgets($comment)));
    $user = htmlspecialchars(rtrim(fgets($comment)));
    $content = "";
    while (($line = fgets($comment)) !== False) {
        $content .= $line;
    }
    $content = htmlspecialchars($content);
    echo "<li class=\"comment\">Rodzaj: $reaction<br/> Treść: $content<br/><span class=\"date\">$date</span><br/><span class=\"user\">Autor: $user</span></li>";
    fclose($comment);
}

function showBlog($blogPath, $blog)
{
    ?>
<!--    --><?php //echo '<'.'?xml version="1.0" encoding="utf-8"?'.'>'."\n"; ?>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
        <title><?php echo $blog?></title>
    </head>
    <body>
    <?php include("Menu.php") ?>
    <?php
    $info = readFromInfo($blogPath, False);
    echo "<h1>$blog</h1>";
    echo "<div class=\"desc\">";
    echo htmlspecialchars($info["desc"]);
    echo "<br/>Właścicel bloga:";
    echo "<span class=\"user\"><br/>";
    echo htmlspecialchars($info["user"]);
    echo "</span>";
    echo "</div>";

    echo "<ul>";
    foreach (scandir($blogPath) as $entry) {
        if (mb_ereg_match('[0-9]{16}$', $entry)) {
            createHTMLPost($blogPath,$blog, $entry);
        }
    }
    echo "</ul>";
    ?>
    </body>
    </html>
    <?php
}

function listBlogs($BASE_PATH)
{
    ?>
    <?php //echo '<'.'?xml version="1.0" encoding="utf-8"?'.'>'."\n"; ?>
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
    <head>
        <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
        <title>Lista Blogów</title>
    </head>
    <body>

    <?php include("Menu.php") ?>
    <ul>
        <h2>Dostępne blogi:</h2>
        <?php
        foreach (glob("$BASE_PATH/*/info") as $blog) {
            $blogName = dirname($blog);
            $info = readFromInfo($blogName, False);
            $desc = htmlspecialchars($info["desc"]);
            $user = htmlspecialchars($info["user"]);

            $blogActualName = htmlspecialchars(basename($blogName));
            echo "<li><a href=\"?nazwa=$blogActualName\">$blogActualName - $desc [$user]</a></li>";
        }
        ?>
    </ul>
    </body>
    </html>
    <?php
}



$blog = $_GET["nazwa"];
$blogPath = "$BASE_PATH/$blog";
if (!isset($_GET["nazwa"])) {
    listBlogs($BASE_PATH);
} else if (file_exists("$blogPath/info") and is_dir($blogPath)) {
    showBlog($blogPath, $blog);
} else {
    header("Status: 404 Not Found");
    echo "brak takiego bloga";
}
?>
