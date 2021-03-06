var thereWasFileAttachmentCursor    = false;
var resubmitCheckerInterval;

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
    // return 'http://' + window.location.hostname + '/leave-application-v3';
    // return "localhost/leave-application-v3";
    return '../';
}

function getHostDeped () {
    // return 'http://' + window.location.hostname + '/leave-application-v3';
    return '../';
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
    dbClear();
    window.location.assign("login.php");
}

function getAccountType($accountTypeId) {
    $accountTypes = ['', 'User', 'Principal', 'HR', 'SDS', 'Admin'];
    return $accountTypes[$accountTypeId];
}

function reloadPage() {
    location.reload();
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
        var $textNode   = document.createTextNode(i);
        var $optionElementClone = $optionElement.cloneNode(true);
        var date       = new Date(year + "-" + month + "-" + i);
        if(date.getDay() == 6 || date.getDay() == 0) {
            $optionElementClone.setAttribute('disabled', 'true');
            $optionElementClone.setAttribute('class', 'danger-font');
        }

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

function calculateEndDate(year, month, day, days) {
    var date        = year + "-" + month + "-" + day;
    var startDate   = new Date(date);
    var endDate     = "";
    var counter     = 1;
    while(counter <= days) {
        endDate = new Date(startDate.setDate(startDate.getDate() + 1));
        if(endDate.getDay() != 0 && endDate.getDay() != 6){
            counter++;
        }
    }
    return endDate;
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

function closeAllModals() {
    var $modals = $class('modal');
    for(var roll = 0; roll < $modals.length; roll++) {
        $modals.item(roll).style.display = "none";
    }
}

function checkUnsubmittedInSW() {
    navigator.serviceWorker.controller.postMessage('checkUnSubmittedLeaveApplication');
}

function randomAttachmentName() {
    var date = new Date();
    return date.getFullYear() + date.getMonth() + date.getDate() + parseInt(Math.random() * 1000000000000);
}

function saveAttachmentForLater(filename, dataURI) {
    var roll                = 1;
    var datas               = [];
    var dataChunksLength    = 50000;
    while(dataURI) {
        var sub = dataURI.substr(0, dataChunksLength);
        dataURI = dataURI.slice( dataChunksLength );

        var data = {
            id : roll++,
            filename: filename,
            content: sub
        };
        datas.push(data);
        if(!dataURI) {
            dbAddFileAttachments(datas);
        }
    }
}

function fetchFailed(fetchFailed) {
    if(!fetchFailed) {
        fetchFailed = 'fetch-failed';
    } 

    $id('loader-container').style.display   = "none";
    closeAllModals();
    $id(fetchFailed).style.display       = "block";
}

function registerServiceWorker() {
    console.log("Trying....");
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('sw.js').then(function(registration) {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);

            }, function(err) {
                // registration failed :(
                console.log('ServiceWorker registration failed: ', err);
            });
        });
    } else {
        console.log("Service worker do not exists!");
    }
}


function openDatabase() {
    if( indexedDB ) {
        return indexedDB.open("LeaveApplication", 8);
    }
}

function dbGet(key) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"])
            .objectStore("leave-applications")
            .get(key)
            .onsuccess = function (event) {
            return event.target.result;
        };
    };
}

function dbDelete(key) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"], "readwrite")
            .objectStore("leave-applications")
            .delete(key);
    };
}

function dbAdd(data) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"], "readwrite")
            .objectStore("leave-applications")
            .add(data);
    };
}

function dbClear() {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"], "readwrite")
            .objectStore("leave-applications").clear();
        db.transaction(["file_attachments"], "readwrite")
            .objectStore("file_attachments").clear();
    };

}

function dbDeleteFileAttachments(key) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["file_attachments"], "readwrite")
            .objectStore("file_attachments")
            .delete(key);
    };
}

function dbGetFileAttachments() {
    openDatabase().onsuccess = function (event) {
        var db = event.target.result;
        var request = db.transaction(["file_attachments"], "readwrite")
            .objectStore("file_attachments");

        request.openCursor().onsuccess = function(event) {
            var cursor = event.target.result;
            if(cursor) {
                console.log("... -> ", cursor.value.content.length);
                request.delete(cursor.value.id);
                cursor.continue();
            } else {
                // no more results
            }
        };
    };
}

function dbAddFileAttachments(data) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        var request = db.transaction(["file_attachments"], "readwrite")
            .objectStore("file_attachments");

        for(var roll = 0; roll < data.length; roll++) {
          request.add(data[roll]);
        }
    };
}




