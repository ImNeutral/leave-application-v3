var $leaveApplications = $id('previous-applications-list');
var $loader            = $id('loader-container');


// modal views
var $numberDaysApplied      = $id('number-days-applied');
var $fromDate               = $id('from-date');
var $placeStay              = $id('place-stay');
var $commutationRequested   = $id('commutation-requested');
var $photoAttachmentHolder  = $id('photo-attachment-holder');
var $photoAttachment        = $id('photo-attachment');

var $principal              = $id('principal');
var $hRDepartment           = $id('hr-department');
var $sds                    = $id('sds');

var $viewPhoto              = $id('view-photo');


var page               = 1;

GET('page', page, accountID).then(function (JSONresponse) {
    var num = (page-1) * 10 + 1;

    if(JSONresponse.length <= 0) {
        var tr_          = document.createElement('tr');
        var td           = document.createElement('td');
        var tdTN         = document.createTextNode("No Previous Applications!");
        td.colSpan = 5;
        td.className = "text-center";
        td.appendChild(tdTN);
        tr_.appendChild(td);
        $leaveApplications.appendChild(tr_);
    }

    for(var roll = 0; roll < JSONresponse.length; roll++) {
        var tr              = document.createElement('tr');
        var tdLeaveId       = document.createElement('td');
        var tdNum           = document.createElement('td');
        var tdType          = document.createElement('td');
        var tdDays          = document.createElement('td');
        var tdFromDate      = document.createElement('td');
        var tdStatus        = document.createElement('td');

        var tdLeaveIdTN     = document.createTextNode(JSONresponse[roll].id);
        var tdNumTN         = document.createTextNode(num);
        var tdTypeTN        = document.createTextNode(JSONresponse[roll].type_of_leave);
        var tdDaysTN        = document.createTextNode(JSONresponse[roll].number_days_applied);
        var tdFromDateTN    = document.createTextNode(JSONresponse[roll].from_date);
        var tdStatusTN      = document.createTextNode( JSONresponse[roll].status );

        if(JSONresponse[roll].status == 'Rejected') {
            tdStatus.className = 'danger-font';
        } else if(JSONresponse[roll].status == 'Accepted') {
            tdStatus.className = 'primary-font';
        } else {
            tdStatus.className = 'info-font';
        }
        tdLeaveId.className = "hidden";

        tdLeaveId   .appendChild(tdLeaveIdTN);
        tdNum       .appendChild(tdNumTN);
        tdType      .appendChild(tdTypeTN);
        tdDays      .appendChild(tdDaysTN);
        tdFromDate  .appendChild(tdFromDateTN);
        tdStatus    .appendChild(tdStatusTN);

        tr.className = "dataTR";
        tr.appendChild(tdLeaveId);
        tr.appendChild(tdNum);
        tr.appendChild(tdType);
        tr.appendChild(tdDays);
        tr.appendChild(tdFromDate);
        tr.appendChild(tdStatus);

        $leaveApplications.appendChild(tr);
        num++;
    }
    addClickEvent();
});

function GET(type, number, accountId) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php?" + type + "=" + number;
    url += "&accountId=" + accountId;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETActionOnApplication(id) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/ActionOnApplicationAPI.php?leave_application_id=" + id;
    url += "&allData=true";
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETLeaveApplication(id) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php?id=" + id;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETPhotoAttachment(filename) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/FileAttachmentAPI.php?filename=" + filename;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function addClickEvent() {
    var $trClick    = document.querySelectorAll("tr.dataTR");
    var leaveApplicationPromise;
    $trClick.forEach(function ($eachTr) {
        $eachTr.addEventListener("click", function (e) {
            var element         = this;
            var applicationId   = element.children[0].textContent;
            hideActionsOnApplication();
            modalTitle.textContent = element.children[2].textContent + " Leave";
            modal.style.display = "block";
            $loader.style.display = 'block';
            leaveApplicationPromise     = GETLeaveApplication(applicationId).then(function (JSONLeaveApplication) {
                replaceContentLeaveApplication(JSONLeaveApplication);
                return JSONLeaveApplication;
            });
            GETActionOnApplication(applicationId).then(function (JSONActionOnApplication) {
                replaceContentActionOnApplication(JSONActionOnApplication);
            }).then(function () {
                $loader.style.display = 'none';
            });
        });
    });

    $photoAttachment.addEventListener("click", function (e) {
        $loader.style.display = "block";
        var $photo = $viewPhoto.querySelector('#photo');
        leaveApplicationPromise.then( function (response) {
            if(response.filename > " ") {
                GETPhotoAttachment(response.filename).then(function (JSONPhoto) {
                    $photo.src = JSONPhoto;
                    $photo.addEventListener('load', function () {
                        hide($loader);
                        show($viewPhoto);
                    });
                });
            }
        });
    });

}

function replaceContent(element, newContent) {
    element.textContent = newContent;
}

function replaceContentLeaveApplication(leaveApplication) {
    replaceContent($numberDaysApplied,  leaveApplication.number_days_applied);
    replaceContent($fromDate,           formatDate(leaveApplication.from_date));
    replaceContent($placeStay,          (placeStay(leaveApplication.place_stay) + leaveApplication.place_stay_specify) );

    if(leaveApplication.commutation_requested == '1') {
        replaceContent($commutationRequested,   'Yes');
    } else {
        replaceContent($commutationRequested,   'No');
    }
    if( leaveApplication.filename > " " ) {
        show($photoAttachmentHolder);
    } else {
        hide($photoAttachmentHolder);
    }
}

function placeStay(placeStay){
    if(placeStay > " ") {
        place = placeStay.split("_");
        newPlaceStay = "";
        for (roll = 0; roll < place.length; roll++) {
            newPlaceStay += place[roll][0].toUpperCase() + place[roll].slice(1) + " ";
        }
        return newPlaceStay + ", ";
    } else {
        return "...";
    }
}

function replaceContentActionOnApplication(actionOnApplication) {
    var next = true;
    if( next ) {
        next = replaceContentPrincipal(actionOnApplication['school_head_approved'], actionOnApplication['action_on_application']);
    }
    if( next ) {
        next = replaceContentHR(actionOnApplication['hr_approved'], actionOnApplication['action_on_application']);
    }
    if( next ) {
        next = replaceContentSDS(actionOnApplication['division_head_approved'], actionOnApplication['action_on_application']);
    }
}

function replaceContentPrincipal(principalAction, actionOnApplication) {
    show($principal);
    return replaceContentByOffice( $principal, principalAction, actionOnApplication.school_head_approved );
}

function replaceContentHR(hrAction, actionOnApplication) {
    show($hRDepartment);
    return replaceContentByOffice( $hRDepartment, hrAction, actionOnApplication.hr_approved );
}

function replaceContentSDS(SDSAction, actionOnApplication) {
    show($sds);
    return replaceContentByOffice( $sds, SDSAction, actionOnApplication.division_head_approved );
}

function replaceContentByOffice($element, action, approved) {
    show($element);
    $action             = $element.querySelector("#action");
    $reasonHolder       = $element.querySelector("#reason-holder");
    $reason             = $element.querySelector("#reason");
    next                = false;

    if( approved ) {
        if(approved == 0) {
            $element.className = "danger-font";
            $action.textContent = "Rejected!";
            if(action.disapproval_due_to > " ") {
                $reason.textContent = action.disapproval_due_to;
                $reasonHolder.style.display = "";
            }
        } else if( approved == 1 ) {
            $element.className ="primary-font";
            $action.textContent = "Accepted!";
            next = true;
        }
    } else {
        $element.className = "info-font";
        $action.textContent = "No Response Yet!";
    }

    return next;
}

function formatDate(date) {
    month = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    dayName = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    newDate = new Date(date);
    newDateString = month[newDate.getMonth()] + " " + newDate.getDate() + ", " + newDate.getFullYear() + " - " + dayName[newDate.getDay()];
    return newDateString;
}

function hideActionsOnApplication() {
    hide($principal);
    hide($hRDepartment);
    hide($sds);
    hide($principal.querySelector("#reason-holder"));
    hide($hRDepartment.querySelector("#reason-holder"));
    hide($sds.querySelector("#reason-holder"));
}

