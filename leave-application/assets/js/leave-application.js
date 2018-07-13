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

var $leaveApplicationForm   = $id('leave-application-form');
var $fileToUpload           = $id('fileToUpload');

var $confirmModal           = $id('confirmModal');
var $confirmSubmitModal     = $id('confirmSubmitModal');
var $confirmSubmitOk        = $id('confirmSubmit_Ok');

var $submittingOfflineMessage   = $id('submitting-offline-message');
var $formContainer          = $id('form-container');

var $loader                 = $id('loader-container');

var submit                  = false;
var typeOfLeave             = 'Sick';
var fileDataURI             = '';
var formContent             = '';

checkUnSubmittedApplications();
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
                $loader.style.display = 'none';
                modalIn($confirmModal);
            } else {
                alert("Failed to submit application.");
            }
        }, function (err) {
            checkUnSubmittedApplications();
            closeAllModals();
            setTimeout(function () {
                $loader.style.display = "none";
            }, 1000);
        });
    }
});

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

    var url = "http://" + getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php";
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

    obj[ 'fileDataURI' ] = fileDataURI;
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

function checkUnSubmittedApplications() {
    var db;
    var thereExist = false;
    timeoutHolder = setInterval(function () {
        openDatabase().onsuccess = function (event) {
            db = event.target.result;
            db.transaction(["leave-applications"])
                .objectStore("leave-applications")
                .get(1)
                .onsuccess = function (event) {
                if( event.target.result ) {
                    $submittingOfflineMessage.style.display = "block";
                    $formContainer.style.display            = "none";
                    thereExist = true;
                } else {
                    $submittingOfflineMessage.style.display = "none";
                    $formContainer.style.display            = "block";
                    clearInterval(timeoutHolder);
                    if(thereExist) {
                        modalIn($confirmModal);
                    }
                }
            };
        };
    }, 1000);
}