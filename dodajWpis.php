<?php echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'."\n"; ?>

<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xml:lang="en" lang="pl">
<head>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset =utf-8"/>
    <title>Tworzenie Wpisu</title>

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
if ($_GET["err"] == "blad"){
    ?>
    <p>Wystąpił bład!</p>
    <?php
}
?>

<form action="wpis.php" enctype="multipart/form-data" method="post" onsubmit="return checkForm(this)" >
    <label for="user">Wpisz nazwe użytkownika:</label><br/>
    <input name="user" id="user" type="text"/><br/>

    <label for="password">Wpisz hasło:</label><br/>
    <input name="password" id="password" type="password"/><br/>

    <label for="blogentry">Treść:</label><br/>
    <textarea name="blogentry" id="blogentry" cols="60" rows="10"></textarea><br/>


    <label for="date">Dzisiejsza data:</label><br/>
    <input name="date" id="date"  value="<?php echo date('Y-m-d'); ?>"/><br/>

    <label for="time">Aktualna godzina:</label><br/>
    <input name="time" id="time"  type="text"  value="<?php echo date('H:i'); ?>"/><br/>

    <p>Liczba wybranych plikow:</p>
    <input type="text" name="filenr" id="filenr" value=0>


    <p>Wybierz pliki:</p>
    <div id="container">
        <input type="file" name="files[0]" onchange="manyFiles(this)" /><br/>
    </div>

<!--    <label for="files0">Wybierz plik:</label><br/>-->
<!--    <input type="file" id="files0" name="files[0]"/><br/>-->
<!--    <input type="file" id="files1" name="files[1]"/><br/>-->
<!--    <input type="file" id="files2" name="files[2]"/><br/>-->
    <br/>
    <input type="submit" value="Utwórz"/><br/>
    <br/>
    <input type="reset" value="Wyczyść"/>

</form>

<script type="text/javascript">
    //Ustawianie czasu
    function setTime() {
        var now = new Date(), // Przypisanie kolejno godziny, minut, roku, miesiaca i dnia
            h = now.getHours(),
            m = now.getMinutes(),
            y = now.getFullYear(),
            month = now.getMonth() + 1, // +1, bo miesiace sa indeksowane od 0 do 11
            d = now.getDate();

        if (h < 10) { h = "0" + h; } // Dodawanie 0 dla jednocyfrowych wartosci
        if (m < 10) { m = "0" + m; }
        if (month < 10) { month = "0" + month; }
        if (d < 10) { d = "0" + d; }

        document.getElementById("time").value = h + ":" + m;
        document.getElementById("date").value = y + "-" + month + "-" + d;
    }

    setTime(); // Ustawiam od razu prawidlowy czas i date

    function checkTime(form){

        var regex = /^(\d{2}):(\d{2})$/, // Wyrazenie regularne reprezentujace godzine np. 13:45
            fit = form.time.value.match(regex); // Porownanie wartosci z formularza z regexem

        if(form.time.value != ""){
            if (!fit) { // Jesli wpisany czas nie odpowiada formatowi HH:MM
                return false;
            }
            if (fit[1] > 23) { // Jesli wpisane godziny sa wieksze od 23
                return false;
            }
            if (fit[2] > 59) { // Jesli wpisane minuty sa wieksze od 59
                return false;
            }
        } else { // Jesli nie wpisano czasu w odpowiednie miejsce formularza
            return false;
        }
        return true;
    }

    // Sprawdzanie daty
    function checkDate(form) {
        var regex = /^(\d{4})-(\d{2})-(\d{2})$/, // Wyrazenie regularne reprezentujace np. 9999-45-13
            fit = form.date.value.match(regex);

        if (form.date.value != "") {
            if (!fit) {
                return false;
            }

            var y = fit[1],
                m = fit[2],
                d = fit[3]; // Odpowiednio rok, miesiac, dzien

            if (y < 2019) {
                return false;
            }
            if (m > 12) {
                return false;
            }
            if (m == 2) { // Luty
                if ((y % 4 == 0 && y % 100 != 0) || y % 400 == 0) { // Czy rok przestepny
                    if (d > 29) { // Rok przestepny, wiec miesiac ma maks 29 dni
                        return false;
                    }
                } else {
                    if (d > 28) { // Rok nie przestepny
                        return false;
                    }
                }
            }
            if (m == 4 || m == 6 || m == 9 || m == 11) {
                if (d > 30) {
                    return false;
                }
            }
            if (d > 31) { // Jesli wpisany miesiac ma max 31 dni i wpisano wiecej niz 31 dni
                return false;
            }
        } else { // Nie wpisano daty
            return false;
        }
        return true;
    }

    function checkForm(form) {
        if (!checkTime(form) && !checkDate(form)) { // Czas i data sie nie zgadza
            alert("Czas i data wprowadzona nieprawidłowo!");
            setTime(); // Ustawienie od nowa aktualnego czasu i daty
            return false;
        } else if (!checkTime(form)) { // Tylko czas sie nie zgadza
            alert("Czas wprowadzony nieprawidłowo!");
            setTime();
            return false;
        } else if (!checkDate(form)) { // Tylko data się nie zgadza
            alert("Data wprowadzona nieprawidłowo!");
            setTime();
            return false;
        }
        alert("Dodano wpis!"); // Sukces
        return true;
    }

    function manyFiles(form) {
        var container = document.getElementById("container"), // Pobranie div z plikami
            number = container.children.length, // Pobranie ilosci wszystkich znacznikow w divie
            files = number / 2; //Usuwanie znacznika <br/>
        document.getElementById("filenr").value = files; // Uaktualniamy liczbe uploadowanych plikow

        for (var i = 0; i < number; i += 2) { // Sprawdzenie, czy do ktoregos z dostepnych inputow file nie podano pliku
            if (container.children[i].value == "") {
                document.getElementById("filenr").value = files;
                return;
            }
        }

        var input = document.createElement("input");
        input.type = "file"; // Ustawienie atrybutu type inputa na "file"
        input.name = "files" + "["+ files+"]"; // Ustawienie nazwy inputa na "file + ilosc inputow file"
        input.onchange = function() { manyFiles(this); }; // Rekurencyjnie jesli zmieni sie onChange
        container.appendChild(input);
        container.appendChild(document.createElement("br"));
    }

</script>


</body>
</html>