<?php echo '<'.'?xml version="1.0" encoding="utf-8"?'.'>'."\n"; ?>
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
    <title>Tworzenie bloga</title>

    <link type="text/css" rel="stylesheet" title="domyślny" href="styles.css"/>
    <link type="text/css" rel="alternate stylesheet" title="alternatywny" href="other.css"/>
    <link type="text/css" rel="alternate stylesheet" title="alternatywny" href="other1.css"/>
    <link type="text/css" rel="alternate stylesheet" title="alternatywny2" href="another.css"/>
    <link type="text/css" rel="stylesheet"  href="persistant.css"/>

    <script type="text/javascript" src="cookie_styles.js"></script>
</head>
<body onload="listOfStyles()">
<ul id="styleList"> </ul>
<?php  include("Menu.php") ?>
<?php
if ($_GET["err"] == "zajete"){
    ?>
    <p>Taki blog już istnieje!</p>
<?php
}
    ?>


<form action="nowy.php" method="post">
    <label for="blogname">Wpisz nazwę bloga:</label><br/>
    <input name="blogname" id="blogname" type="text"/><br/>
    <br/>
    <label for="blogdesc">Wpisz opis bloga:</label><br/>
    <textarea name="blogdesc" id="blogdesc" cols="60" rows="10"></textarea><br/>
    <br/>
    <label for="user">Wpisz nazwę użytkownika:</label><br/>
    <input name="user" id="user" type="text"/><br/>
    <br/>
    <label for="password">Wpisz hasło użytkownika:</label><br/>
    <input name="password" id="password" type="password"/><br/>

    <br/>
    <input type="submit" value="Utwórz"/><br/>
    <br/>
    <input type="reset" value="Wyczyść"/>
</form>

</body>
</html>