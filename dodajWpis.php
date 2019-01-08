<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>

<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xml:lang="en" lang="pl">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
    <title>Tworzenie Wpisu</title>




</head>
<body>
<?php  include("Menu.php") ?>
<?php
if ($_GET["err"] == "blad"){
    ?>
    <p>Wystąpił bład!</p>
    <?php
}
?>

<form action="wpis.php" enctype="multipart/form-data" method="post">
    <label for="user">Wpisz nazwe użytkownika:</label><br/>
    <input name="user" id="user" type="text"/><br/>

    <label for="password">Wpisz hasło:</label><br/>
    <input name="password" id="password" type="password"/><br/>

    <label for="blogentry">Treść:</label><br/>
    <textarea name="blogentry" id="blogentry" cols="60" rows="10"></textarea><br/>


    <label for="date">Dzisiejsza data:</label><br/>
    <input name="date" id="date" readonly="readonly" value="<?php echo date('Y-m-d'); ?>"/><br/>

    <label for="time">Aktualna godzina:</label><br/>
    <input name="time" id="time" readonly="readonly" type="text"  value="<?php echo date('H:i'); ?>"/><br/>

    <label for="files0">Wybierz plik:</label><br/>
    <input type="file" id="files0" name="files[0]"/><br/>
    <input type="file" id="files1" name="files[1]"/><br/>
    <input type="file" id="files2" name="files[2]"/><br/>
    <br/>
    <input type="submit" value="Utwórz"/><br/>
    <br/>
    <input type="reset" value="Wyczyść"/>

</form>
</body>
</html>