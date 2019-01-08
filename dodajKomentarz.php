<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>

<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="pl">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
    <title>Tworzenie Wpisu</title>
</head>
<body>
<?php  include("Menu.php") ?>
<?php
if ($_GET["err"] == "blad"){
    ?>
    <p>Wystąpił błąd!</p>
    <?php
}
?>


<form action="koment.php?blogname=<?php  echo $_GET["blogname"];?>&amp;entry=<?php  echo $_GET["entry"]; ?>" method="post">
    <label for="reaction">Rodzaj komentarza:</label><br/>
    <select name="reaction" id="reaction">
        <option selected="selected" label="Pozytywna">pozytywny</option>
        <option label="Neutralna">neutralny</option>
        <option label="Negatywna">negatywny</option>
    </select>
    <br/>

    <br/>
    <label for="user">Pseudonim:</label><br/>
    <input name="user" id="user" type="text"/><br/>
    <br/>
    <label for="commententry">Wpisz treść komentarza:</label><br/>
    <textarea name="commententry" id="commententry" cols="80" rows="10"></textarea><br/>
    <br/>
    <input type="submit" value="Utwórz"/><br/>
    <br/>
    <input type="reset" value="Wyczyść"/>
</form>
</body>
</html>