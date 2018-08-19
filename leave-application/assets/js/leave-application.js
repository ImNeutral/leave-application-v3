document.title = "Leave Application | Application Form";
$id('leave-application').className = 'active';

var $typeOfLeave            = $id('type_of_leave');
var $othersReason           = $id('others_reason_holder');
var $othersReasonInput      = $id('others_reason');
var $whereLeaveBeSpend      = $id('where_leave_be_spend_holder');
var $vacationPlace          = $id('vacation_leave_place_holder');
var $daysAppliedHolder      = $id('days_applied_holder');
var $daysApplied            = $id('days_applied');
var $sickPlace              = $id('sick_leave_place_holder');

var $dateFromYear           = $id('date_from_year');
var $dateFromMonth          = $id('date_from_month');
var $dateFromDay            = $id('date_from_day');

var $accountID              = $id('account_id');
var $schoolID               = $id('school_id');

var $dateFilled             = $id('date-filled');
var $endDate                = $id('end_date');

var $leaveApplicationForm   = $id('leave-application-form');
var $fileToUpload           = $id('fileToUpload');

var $confirmModal           = $id('confirmModal');
var $confirmSubmitModal     = $id('confirmSubmitModal');
var $confirmSubmitOk        = $id('confirmSubmit_Ok');

var $submittingOfflineMessage   = $id('submitting-offline-message');
var $thereIsUnsubmittedMessage  = $id('thereIsUnsubmitted-message');
var $formContainer          = $id('form-container');

var $loader                 = $id('loader-container');

var submit                  = false;
var thereWasLeaveApplication = false;
var typeOfLeave             = 'Sick';
var fileDataURI             = '';
var formContent             = '';


connectionLost();
checkUnsubmittedInSW();
checkUnSubmittedApplications();
checkUnfinishedApplication();

selectDateNow($dateFromMonth, $dateFromDay);

initValues();
selectTypeOfLeave();
$dateFilled.innerText = formatDate(new Date());

$fileToUpload.addEventListener('change', function (e) {
    var file  = $fileToUpload.files[0];
    var reader  = new FileReader();
    reader.readAsDataURL(file);

    reader.addEventListener("load", function () {
        var $image = $id('hiddenImage');
        $image.src = reader.result;
        $image.addEventListener("load", function (e) {
            $image = e.target;
            fileDataURI = imageResizeToNewDataUri($image, $image.width/2, $image.height/2);
        });
    }, false);
});

$leaveApplicationForm.addEventListener('submit', function (e) {
    e.preventDefault();
    formContent = this;
    submit = true;
    modalIn($confirmSubmitModal);
});

$confirmSubmitOk.addEventListener('click',function (e) {
    if(submit) {
        modalOut($confirmSubmitModal);
        $loader.style.display = 'block';
        POST(formContent, fileDataURI).then(function(response){
            return response.json();
        }).then(function (responseJson) {
            if(responseJson) {
                thereWasLeaveApplication = true;
                submitFileAttachments();
            } else {
                alert("Failed to submit application.");
            }
        }, function (err) {
            fetchFailed('fetch-failed-leave-application');
            checkUnsubmittedInSW();
            checkUnSubmittedApplications();
        });
    }
});


function connectionLost() {
    var $connectionLost = $id('connection-lost');
    window.addEventListener('online', function () {
        $connectionLost.style.display = "none";
    });
    window.addEventListener('offline', function () {
        $connectionLost.style.display = "block";
    });
}

function initValues() {
    $accountID.value = accountID;
    $schoolID.value  = schoolID;
}

function selectTypeOfLeave () {
    typeOfLeave = $typeOfLeave.value;
    if(typeOfLeave == 'others' || typeOfLeave == 'vacation-others') {
        $othersReasonInput.removeAttribute('disabled');
        $othersReason.style.opacity = '1';
    } else {
        $othersReasonInput.setAttribute('disabled', 'true');
        $othersReason.style.opacity = '.1';
    }

    if(typeOfLeave == 'Sick' || typeOfLeave == 'vacation-employment' || typeOfLeave == 'vacation-others') {
        $whereLeaveBeSpend.style.display = 'block';

        if(typeOfLeave == 'Sick') {
            $sickPlace.style.display = 'block';
            $vacationPlace.style.display = 'none';
        }

        if(typeOfLeave == 'vacation-employment' || typeOfLeave == 'vacation-others') {
            $vacationPlace.style.display = 'block';
            $sickPlace.style.display = 'none';
        }

    } else {
        $whereLeaveBeSpend.style.display = 'none';
    }

    if(typeOfLeave == 'Maternity') {
        $daysAppliedHolder.style.display = 'none';
        $daysApplied.setAttribute('disabled', 'true');
    } else {
        $daysAppliedHolder.style.display = 'block';
        $daysApplied.removeAttribute('disabled');
    }

}

function monthChangedFrom() {
    setDayValue($dateFromYear.value, $dateFromMonth.value, $dateFromDay);
}

function POST($form, fileDataURI) {
    // var data = new FormData(form);
    var data = toJSONString($form, fileDataURI);

    var url = getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php";
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: data
    }; 
    return fetch(url, init);
}

function toJSONString( form, fileDataURI ) {
    var obj = {};
    var elements = form.querySelectorAll( "input, select, textarea" );
    for( var i = 0; i < elements.length; ++i ) {
        var element = elements[i];
        var name = element.name;
        var value = element.value;
        if( name ) {
            obj[ name ] = value;
        }
    }

    if(fileDataURI > ' ') {
        obj['attachmentName'] = randomAttachmentName();
        saveAttachmentForLater(obj['attachmentName'], fileDataURI);
    }
    // obj[ 'fileDataURI' ] = fileDataURI;

    if( document.querySelector('input[name="place"]:checked') ) {
        obj[ 'place' ] = document.querySelector('input[name="place"]:checked').value;
    } else {
        obj[ 'place' ] = '';
    }

    if( document.querySelector('input[name="commutation_requested"]:checked') ) {
        obj[ 'commutation_requested' ] = document.querySelector('input[name="commutation_requested"]:checked').value;
    } else {
        obj[ 'commutation_requested' ] = '0';
    }

    return JSON.stringify( obj );
}

$dateFromDay.addEventListener('change', function () {
    changeEndDate();
});

$daysApplied.addEventListener('change', function () {
    changeEndDate();
});

function changeEndDate() { 
    var days        = $daysApplied.value;
    var day         = $dateFromDay.value;
    var month       = $dateFromMonth.value;
    var year        = $dateFromYear.value;

    $endDate.innerText = formatDate( calculateEndDate(year, month, day, days) );
}

function checkUnSubmittedApplications() {
    var db;
    var thereExist = false;
    thereWasLeaveApplication = false;
    var timeoutHolder = setInterval(function () {
        openDatabase().onsuccess = function (event) {
            db = event.target.result;
            db.transaction(["leave-applications"])
                .objectStore("leave-applications")
                .get(1)
                .onsuccess = function (event) {
                if( event.target.result ) {
                    $id('success-message').innerText = "Submitting/Updating Leave Application, please connect to internet and wait...";
                    $submittingOfflineMessage.style.display = "block";
                    $formContainer.style.display            = "none";
                    thereExist                              = true;
                    thereWasLeaveApplication                = true;
                } else {
                    clearInterval(timeoutHolder);
                    if(thereExist) {
                        $submittingOfflineMessage.style.display = "none";
                        $formContainer.style.display            = "block";
                    }
                    submitFileAttachments();
                }
            };
        };
    }, 500);
}

function submitFileAttachments() {
    var thereExist = false;
    var timeoutHolder = setInterval(function () {
        openDatabase().onsuccess = function (event) {
            var db = event.target.result;
            var request = db.transaction(["file_attachments"], "readwrite")
                .objectStore("file_attachments");

            request.openCursor().onsuccess = function(event) {
                var cursor = event.target.result;
                if (cursor) {
                    $id('success-message').innerText = "Submitting/Updating File Attachments, please connect to internet and wait...";
                    $submittingOfflineMessage.style.display     = "block";
                    $formContainer.style.display                = "none";
                    thereExist = true;
                } else {
                    $loader.style.display       = "none";
                    clearInterval(timeoutHolder);
                    if(thereExist) {
                        $submittingOfflineMessage.style.display = "none";
                        $formContainer.style.display            = "block";
                        modalIn($confirmModal);
                    }
                    if(thereWasLeaveApplication) {
                        $submittingOfflineMessage.style.display = "none";
                        $formContainer.style.display            = "block";
                        modalIn($confirmModal);
                    }
                }
            }
        };
    }, 1000);
}

function checkUnfinishedApplication() {
    var url = getHost() + "leave-application-api-capstone/LeaveApplicationAPI.php?check_unfinished_application=true";
    url += "&account_id=" + accountID ;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    console.log(url);
    fetch(url, init).then(function(response){
        return response.json();
    }).then(function (response) {
        localStorage.setItem('thereIsUnfinished', response);
        console.log(response);
        if( response ) {
            $leaveApplicationForm.style.display         = "none";
            $thereIsUnsubmittedMessage.style.display    = "block";
        }
    }, function (err) {
        if( localStorage.getItem('thereIsUnfinished') ) {
            $leaveApplicationForm.style.display = "none";
            $thereIsUnsubmittedMessage.style.display    = "block";
        }
    });
}

// function checkUnSubmittedApplications() {
//     var db;
//     checkConnectionLabelInterval();
//
//     timeoutHolder = setInterval(function () {
//         openDatabase().onsuccess = function (event) {
//             db = event.target.result;
//             db.transaction( ["leave-applications"])
//                 .objectStore("leave-applications")
//                 .get(1)
//                 .onsuccess = function (event) {
//                     if( !event.target.result ) {
//                         console.log("Testing for leave apps", event.target.result);
//                         $submittingOfflineMessage.style.display = "none";
//                         $formContainer.style.display            = "block";
//                         clearInterval(timeoutHolder);
//                         submitFileAttachments();
//                     }
//             };
//         };
//     }, 2000);
// }


// function submitFileAttachments() {
//     openDatabase().onsuccess = function (event) {
//         var db = event.target.result;
//         var request = db.transaction(["file_attachments"], "readwrite")
//             .objectStore("file_attachments");
//
//         request.openCursor().onsuccess = function(event) {
//             var cursor = event.target.result;
//             if (cursor) {
//                 checkConnection();
//                 submitFileAttachments();
//             } else {
//                 checkConnectionStop();
//             }
//         }
//     };
// }
//
//
// function checkConnectionStop() {
//     $id('now-offline').style.display = "none";
//     $id('connection-back').style.display = "none";
// }
//
// function checkConnection() {
//     if (!navigator.onLine) {
//         $id('now-offline').style.display = "block";
//         $id('connection-back').style.display = "none";
//     } else {
//         $id('now-offline').style.display = "none";
//         $id('connection-back').style.display = "block";
//     }
//     window.addEventListener('online', function () {
//         $id('now-offline').style.display = "none";
//         $id('connection-back').style.display = "block";
//     });
//     window.addEventListener('offline', function () {
//         $id('now-offline').style.display = "block";
//         $id('connection-back').style.display = "none";
//     });
// }
//
// function checkConnectionLabelInterval() {
//     var $label = $id('connection-back-label');
//     var roll = 1;
//     setInterval(function () {
//         var label = "";
//         for(roll2 = 1; roll2 <= roll; roll2++) {
//             label += ' *'
//         }
//         $label.innerText = label;
//         if(roll == 5) {
//             roll = 1;
//         } else {
//             roll++;
//         }
//     }, 1000);
// }
//
