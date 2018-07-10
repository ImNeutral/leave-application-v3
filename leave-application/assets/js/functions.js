function $id(el) {
    return document.getElementById(el);
}

function $class(el) {
    return document.getElementsByClassName(el);
}

function closeModal(target) {
    var $modalContainer = findAncestor(target, 'modal');
    $modalContainer.style.display = "none";
}

function openModal(target) {
    var $modalContainer = findAncestor(target, 'modal');
    console.log($modalContainer);
    $modalContainer.style.display = "block";
}

function closeViewPhoto(target) {
    var $container = findAncestor(target, 'view-photo');
    $container.style.display = "none";
}

function findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

function getHost() {
    return "localhost/leave-application-v3";
}

function getLoginDetails() {
    var LSaccount = JSON.parse(localStorage.getItem("account"));
    var LSemployee = JSON.parse(localStorage.getItem("employee"));

    var loginDetails = [LSaccount, LSemployee];
    return loginDetails;
}

function isLoggedIn() {
    var loginDetails = getLoginDetails();
    return (loginDetails[0]) ? 1 : 0;
}

function logout() {
    localStorage.removeItem('account');
    localStorage.removeItem('employee');
    window.location.assign("login.php");
}

function getAccountType($accountTypeId) {
    $accountTypes = ['', 'User', 'Principal', 'HR', 'SDS', 'Admin'];
    return $accountTypes[$accountTypeId];
}

function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

function isAllowed(id) {
    var currentLoc      = window.location.href.split('/').pop().split('#')[0].split('?')[0];
    var routes = {
        "login.php"                 : "0",
        "change-password.php"       : "0",
        "leave-application.php"     : "1",
        "previous-applications.php" : "1",
        "manage-accounts.php"       : "5",
        "application-reports.php"   : "5"
    };
    var defaultRoutes = {
        "0" : "login.php",
        "1" : "leave-application.php",
        '2' : "admin-actions.php",
        '3' : "admin-actions.php",
        '4' : "admin-actions.php",
        '5' : "manage-accounts.php"
    };
    if(currentLoc == 'admin-actions.php' && (id == 2 || id == 3 || id == 4 ) ) {
        //do nothing...
    } else if (routes[currentLoc] != id) {
        window.location.assign(defaultRoutes[id]);
    }
}

function modalIn(element) {
    element.style.display = 'block';
}

function modalOut(element) {
    element.style.display = 'none';
}

function hide(element) {
    element.style.display = "none";
}

function show(element) {
    element.style.display = "";
}

function setDayValue(year, month, $day){
    var daysVal     = [31,( (year%4 > 0)? 28: 29 ), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var $optionElement = document.createElement('option');

    while($day.childNodes[0]) {
        $day.removeChild($day.childNodes[0]);
    }

    for(var i = 1; i <= daysVal[month-1]; i++) {
        var $textNode = document.createTextNode(i);
        var $optionElementClone = $optionElement.cloneNode(true);
        $optionElementClone.value = i;
        $optionElementClone.appendChild($textNode);
        $day.appendChild($optionElementClone)
    }
}

function showMessage($el, type, message) {
    var $br             = document.createElement('br');
    $el.className       = 'error-message ' + type;
    $el.innerText       = "";
    for(var roll = 0; roll < message.length; roll++) {
        if($el.innerText += message[roll]) {
            $el.appendChild($br);
        }
    }
    if(message.length > 0) {
        $el.style.display = "block";
    } else {
        $el.style.display = "none";
    }
}

function selectDateNow($month, $day) {
    var dateNow     = new Date();
    $month.value = dateNow.getMonth() + 1;
    monthChangedFrom();
    $day.value = dateNow.getDate();
}

function formatDate(date) {
    var month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    var dayName = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    var newDate = new Date(date);
    var newDateString = month[newDate.getMonth()] + " " + newDate.getDate() + ", " + newDate.getFullYear() + " - " + dayName[newDate.getDay()];
    return newDateString;
}

function formatDate2(strDate) {
    var date    = new Date(strDate);
    var month   = ['Jan','Feb','Mar','Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return month[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear();
}

function empty($element) {
    while ($element.firstChild) {
        $element.removeChild($element.firstChild);
    }
}

function createPageButton(page, elId) {
    var $a      = document.createElement('a');
    var $aTN    = document.createTextNode(page);
    if(elId > ' ') {
        $a.id       = elId;
    } else {
        $a.id        = 'page-' + page;
    }
    $a.className = 'button button-primary button-sm pagination';
    $a.setAttribute('data-id', page);
    $a.appendChild($aTN);

    $a.setAttribute('onclick', 'clickedPageButton(this)');
    return $a;
}

function imageResizeToNewDataUri(img, width, height) {

    // create an off-screen canvas
    var canvas = document.createElement('canvas'),
        ctx = canvas.getContext('2d');

    // set its dimension to target size
    canvas.width = width;
    canvas.height = height;

    // draw source image into the off-screen canvas:
    ctx.drawImage(img, 0, 0, width, height);

    // encode image to data-uri with base64 version of compressed image
    return canvas.toDataURL();
}