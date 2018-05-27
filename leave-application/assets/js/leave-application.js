document.title = "Leave Application | Application Form";
$id('leave-application').className = 'active';

$typeOfLeave            = $id('type_of_leave');
$othersReason           = $id('others_reason_holder');
$othersReasonInput      = $id('others_reason');
$whereLeaveBeSpend      = $id('where_leave_be_spend_holder');
$vacationPlace          = $id('vacation_leave_place_holder');
$daysAppliedHolder      = $id('days_applied_holder');
$daysApplied            = $id('days_applied');
$sickPlace              = $id('sick_leave_place_holder');

$dateFromYear           = $id('date_from_year');
$dateFromMonth          = $id('date_from_month');
$dateFromDay            = $id('date_from_day');

$accountID              = $id('account_id');
$schoolID               = $id('school_id');

$leaveApplicationForm   = $id('leave-application-form');
$fileToUpload           = $id('fileToUpload');

var typeOfLeave = 'Sick';
selectDateNow($dateFromMonth, $dateFromDay);

initValues();
selectTypeOfLeave();


var fileDataURI = '';

$fileToUpload.addEventListener('change', function (e) {
    var file  = $fileToUpload.files[0];
    var reader  = new FileReader();
    reader.readAsDataURL(file);

    reader.addEventListener("load", function () {
        fileDataURI = reader.result;
    }, false);
});

$leaveApplicationForm.addEventListener('submit', function (e) {
    e.preventDefault();
    POST(this, fileDataURI);
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

function setDayValue(year, month, $day){
    var daysVal     = [31,( (year%4 > 0)? 28: 29 ), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    var $optionElement = document.createElement('option');

    while($day.childNodes[0]) {
        $day.removeChild($day.childNodes[0]);
    }

    for(var i = 1; i <= daysVal[month-1]; i++) {
        var $textNode = document.createTextNode(i);
        var $optionElementClone = $optionElement.cloneNode(true);
        $optionElement.value = i;
        $optionElementClone.appendChild($textNode);
        $day.appendChild($optionElementClone)
    }
}

function selectDateNow($month, $day) {
    var dateNow     = new Date();
    $month.value = dateNow.getMonth() + 1;
    monthChangedFrom();
    $day.value = dateNow.getDate();
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
    console.log(data);
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

    return JSON.stringify( obj );
}

/*
function submit(e, form){
    var url = "http://" + getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php";
    e.preventDefault();
    fetch(url, {
        method: 'POST',
        body: JSON.stringify({
            id: 4
        }),
        headers: new Headers({
            'Content-Type': 'application/json'
        })
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        console.log(data);
        //Success code goes here
        alert('form submited')
    // }).catch(function(err) {
    //     //Failure
    //     alert('Error')
    });
}
*/