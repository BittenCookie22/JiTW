// Listowanie stylów
function listOfStyles() {
    var list = "";
    var existing_titles = [];
    for (var i = 0; (style = document.getElementsByTagName("link")[i]); i++) { // Pobieranie wszystkich stylow
        if (style.getAttribute("title")) {
            title = style.getAttribute("title");
            if (existing_titles.indexOf(title) < 0) {
                existing_titles.push(title);
                list += "<li><a href=\"#\" onclick=\"setStyle(\'" + title + "\'); return false;\">Styl: " + title + ".</a></li>"; // Dodanie odpowiedniego stringa do listy stylow, zeby sie wyswietlalo jako odnosniki
            }
        }

    }
    document.getElementById("styleList").innerHTML = list; // Wpisanie w element z id="styleList" stworzonego stringa
}

// Ustawienie stylu
function setStyle(name) {
    var style;
    for (var i = 0; (style = document.getElementsByTagName("link")[i]); i++) {
        if (style.getAttribute("title")) {
            style.disabled = true;
            if (style.getAttribute("title") == name) {
                style.disabled = false;
            } //Wlacz ustawiony styl
        }
    }
}

// Pobranie atrybutu title aktywnego stylu
function getStyle() {
    var styl;
    for (var i = 0; (styl = document.getElementsByTagName("link")[i]); i++) {
        if (styl.getAttribute("title") && !styl.disabled) {
            return styl.getAttribute("title");
        }
    }
    return null;
}

// Stworzenie ciasteczka dla stylu
function createCookie(name, styl, days) {
    if (days) {
        var date = new Date();
        //Jeżeli nie podamy tego parametru, wówczas ciastko zostanie utworzone do czasu trwania sesji czyli do czasu wyłączenia przeglądarki
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Dni na milisekundy
        var expires = "; expires=" + date.toGMTString();
    } else expires = "";
    document.cookie = name + "=" + styl + expires + "; path=/"; // Stworzenie cookie
}

// Odczytywanie ciasteczka stylu
function readCookie(name) {
    var name = name + "=";
    var arrayOfCookies = document.cookie.split(';'); // Rozbicie cookie na elementy

    for (var i = 0; i < arrayOfCookies.length; i++) { // Przeszukiwanie ciasteczka w celu znalezienia elementu dotyczacego nazwy stylu
        var cookie = arrayOfCookies[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1, cookie.length);
        } // Pozbycie sie pustych znakow na poczatku
        if (cookie.indexOf(name) == 0) {
            return cookie.substring(name.length, cookie.length); // Pobranie i zwrocenie nazwy stylu (atrybutu title)
        }
    }
    return null;
}

// Ladowanie strony
window.onload = function (e) {
    var styleCookie = readCookie("style"); // Nazwa stylu
    var styleTitle = styleCookie ? styleCookie : getStyle(); // Nazwa stylu z cookie lub aktualna
    setStyle(styleTitle);
}

// Opuszczanie strony
window.onunload = function (e) {
    var styleTitle = getStyle();
    createCookie("style", styleTitle, 999); // Stworzenie cookie
}

// Przy przechodzeniu na inna strone
var styleCookie = readCookie("style");
var styleTitle = styleCookie ? styleCookie : getStyle();
setStyle(styleTitle);
