var $modal                  = $id('application-action');
var $respondModal           = $id('respond-modal');
var $respondSuccessModal    = $id('respond-success-modal');
var $reverseSuccessModal    = $id('reverse-success-modal');
var $reverseActionModal     = $id('reverse-action-modal');
var $connectionBackModal    = $id('connection-back-modal');

var $openReverseAction      = $id('open-reverse-action');
var $confirmReverseAction   = $id('confirm-reverse-action');

var $confirmActionModal     = $id('confirm-action-modal');
var $confirmAction          = $id('confirm-action');

var $modalTitle             = $id('modal-title');
var $submitResponse         = $id('submit-response');

var $principal              = $id('principal');
var $hRDepartment           = $id('hr-department');
var $sds                    = $id('sds');

var $applicationType        = $id('application-type');
var $applicantName          = $id('applicant-name');
var $applicantSchool        = $id('applicant-school');
var $numberDaysApplied      = $id('number-days-applied');
var $fromDate               = $id('from-date');
var $placeStay              = $id('place-stay');
var $commutationRequested   = $id('commutation-requested');
var $photoAttachmentHolder  = $id('photo-attachment-holder');
var $photoAttachment        = $id('photo-attachment');
var $viewPhoto              = $id('view-photo');

var $loader                 = $id('loader-container');

var $leaveApplications      = $id('applications-list');
var $newApplications        = $id('new-applications');
var $acceptedApplications   = $id('accepted-applications');
var $rejectedApplications   = $id('rejected-applications');

var $pagination             = $id('pagination');
var $header                 = $id('header');

var status                  = 'NULL';
var page                    = 1;
var submitAction            = false;

var rejected                = false;
var rejectedBy              = "";
var reverseActionNow        = false;

populateApplicationsTable();
addPagination();
connectionListener();

$confirmAction.addEventListener('click', function (e) {
    if(submitAction) {
        $loader.style.display = "block";
        leaveApplicationPromise.then(function (response) {
            submitApplicationAction(response.id).then(function () {
                $modal.style.display                = "none";
                $respondModal.style.display         = "none";
                $confirmActionModal.style.display   = "none";
                $loader.style.display               = "none";
                $respondSuccessModal.style.display  = "block";

                emptyPagination();
                addPagination();
                populateApplicationsTable();
            }, function (err) {
                fetchFailed();
            });
        });
        submitAction = false;
    }
});

$confirmReverseAction.addEventListener('click', function (e) {
    if(reverseActionNow) {
        $loader.style.display = "block";
        leaveApplicationPromise.then(function (response) {
            reverseAction(response.id).then(function () {
                $modal.style.display                = "none";
                $reverseActionModal.style.display   = "none";
                $loader.style.display               = "none";
                $reverseSuccessModal.style.display  = "block";

                emptyPagination();
                addPagination();
                populateApplicationsTable();
            }, function (err) {
                fetchFailed();
            });
        });
        reverseActionNow = false;
    }
});

$submitResponse.addEventListener('click', function (e) {
    submitAction = true;
    $confirmActionModal.style.display = "block";
});

$newApplications.addEventListener('click', function (e) {
    setDefaults(this, 'NULL', 'New Applications');
});

$acceptedApplications.addEventListener('click', function (e) {
    setDefaults(this, '1', 'Accepted Applications');
});

$rejectedApplications.addEventListener('click', function (e) {
    setDefaults(this, '0', 'Rejected Applications');
});

function connectionListener() {
    window.addEventListener('online', function () {
        $connectionBackModal.style.display = "block";
    });

    window.addEventListener('offline', function () {
        $connectionBackModal.style.display = "none";
    });
}

function setDefaults(element, _status, _textContent) {
    removeActive();
    status      = _status;
    page        = 1;
    emptyPagination();
    addPagination();
    $header.textContent = _textContent;
    element.classList.add('active');
    populateApplicationsTable();
}

function hideActionsOnApplication() {
    hide($principal);
    hide($hRDepartment);
    hide($sds);
    hide($principal.querySelector("#reason-holder"));
    hide($hRDepartment.querySelector("#reason-holder"));
    hide($sds.querySelector("#reason-holder"));
}


function populateApplicationsTable() {
    empty($leaveApplications);
    $loader.style.display = "block";
    GETLeaveApplications().then(function (JSONresponse) {
        var num = (page-1) * 10 + 1;

        if(JSONresponse.length <= 0) {
            var tr_          = document.createElement('tr');
            var td           = document.createElement('td');
            var tdTN         = document.createTextNode("Currently No Applications!");
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

            tdDays.id       = "days";
            tdFromDate.id   = "from-date";

            var tdLeaveIdTN     = document.createTextNode(JSONresponse[roll].id);
            var tdNumTN         = document.createTextNode(num);
            var tdTypeTN        = document.createTextNode(JSONresponse[roll].type_of_leave);
            var tdDaysTN        = document.createTextNode(JSONresponse[roll].number_days_applied);
            var tdFromDateTN    = document.createTextNode(formatDate2( JSONresponse[roll].from_date ));

            tdLeaveId.className = "hidden";

            tdLeaveId   .appendChild(tdLeaveIdTN);
            tdNum       .appendChild(tdNumTN);
            tdType      .appendChild(tdTypeTN);
            tdDays      .appendChild(tdDaysTN);
            tdFromDate  .appendChild(tdFromDateTN);

            tr.className = "dataTR";
            tr.appendChild(tdLeaveId);
            tr.appendChild(tdNum);
            tr.appendChild(tdType);
            tr.appendChild(tdDays);
            tr.appendChild(tdFromDate);

            $leaveApplications.appendChild(tr);
            num++;
        }
        $loader.style.display = "none";
        addClickEvent();
    }, function (err) {
        fetchFailed();
    });
}

function getStatusChecker() {
    var status = "In: Principal";
    if(accountTypeID == 3) {
        status = "In: HR";
    } else if(accountTypeID == 4) {
        status = "In: SDS";
    }
    return status;
}

function actionTableId() {
    var tableId    = 'principal';
    if(accountTypeID == 3) {
        tableId = 'hr-department'
    }
    return tableId;
}

function isReversible(status) {
    var reversible = false;
    if(accountTypeID == 2 && status == 'In: HR') {
        reversible = true;
    } else if(accountTypeID == 3 && status == 'In: SDS') {
        reversible = true;
    }
    if(rejected && rejectedBy == actionTableId()) {
        reversible = true;
    }
    return reversible;
}


function addClickEvent() {
    var $trClick    = document.querySelectorAll("tr.dataTR");
    $trClick.forEach(function ($eachTr) {
        $eachTr.addEventListener("click", function (e) {
            $latestClicked      = this;
            var element         = this;
            var applicationId   = element.children[0].textContent;
            hideActionsOnApplication();
            $applicationType.textContent = element.children[2].textContent;
            $modal.style.display = "block";
            $loader.style.display = 'block';
            rejected = false;
            rejectedBy = "";
            leaveApplicationPromise     = GETLeaveApplication(applicationId).then(function (JSONLeaveApplication) {
                replaceContentLeaveApplication(JSONLeaveApplication);
                if(JSONLeaveApplication.cancelled == '1' || JSONLeaveApplication.status != getStatusChecker()) {
                    hide($id('open-edit-modal'));
                } else {
                    $id('open-edit-modal').style.display = "";
                }
                return JSONLeaveApplication;
            }, function (err) {
                fetchFailed();
            });
            GETActionOnApplication(applicationId).then(function (JSONActionOnApplication) {
                replaceContentActionOnApplication(JSONActionOnApplication);
            }).then(function () {
                leaveApplicationPromise.then(function (JSONLeaveApplication) {
                    if(JSONLeaveApplication.cancelled == '1' || JSONLeaveApplication.status != getStatusChecker()) {
                        if( isReversible(JSONLeaveApplication.status ) ) {
                            $openReverseAction.style.display = "";
                        } else {
                            $openReverseAction.style.display = "none";
                        }
                    } else {
                        $openReverseAction.style.display = "none";
                    }
                });
                $loader.style.display = 'none';
            }, function (err) {
                fetchFailed();
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
                }, function (err) {
                    fetchFailed();
                });
            }
        });
    });
}

function GETActionOnApplication(id) {
    var url = getHost() + "/leave-application-api-capstone/ActionOnApplicationAPI.php?leave_application_id=" + id;
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

function GETLeaveApplicationOwner(accId) {
    var url = getHost() + "/leave-application-api-capstone/AccountAPI.php?";
    url     += "account_id=" + accId;
    url     += "&owner=true";
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
    var url = getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php?id=" + id;
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
    var url = getHost() + "/leave-application-api-capstone/FileAttachmentAPI.php?filename=" + filename;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETLeaveApplications() {
    var url = getHost() + "/leave-application-api-capstone/ActionOnApplicationAPI.php?";
    url     += "admin_type_id=" + accountTypeID;
    url     += "&status=" + status;
    url     += "&page=" + page;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETLeaveApplicationCount() {
    var url = getHost() + "/leave-application-api-capstone/ActionOnApplicationAPI.php?";
    url     += "admin_type_id=" + accountTypeID;
    url     += "&status=" + status;
    url     += "&count=true";
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function submitApplicationAction(leaveApplicationId) {
    var $obj = {
        leave_application_id    : leaveApplicationId,
        admin_type_id           : accountTypeID,
        approved                : $id('response-type').value,
        for                     : $id('response-reason').value
    };
    var data = JSON.stringify($obj);
    $id('response-type').value      = "1";
    $id('response-reason').value    = "";
    return PUTApplicationAction(data);
}

function reverseAction(leaveApplicationId) {
    var $obj = {
        leave_application_id    : leaveApplicationId,
        admin_type_id           : accountTypeID,
        reverse_action          : "true"
    };
    var data = JSON.stringify($obj);
    return PUTReverseAction(data);
}

function PUTApplicationAction(data) {
    var url = getHost() + "/leave-application-api-capstone/ActionOnApplicationAPI.php";
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: data
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function PUTReverseAction(data) {
    var url = getHost() + "/leave-application-api-capstone/ActionOnApplicationAPI.php";
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: data
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}


function clickedPageButton($e) {

    leaveApplicationCountPromise.then(function (result) {
        var pages = Math.ceil( result.total / 10 );


        if(page == pages) {
            $id('pagination-previous').style.display = '';
            $id('pagination-next').style.display = 'none';
        } else if(page == 1) {
            $id('pagination-next').style.display = '';
            $id('pagination-previous').style.display = 'none';
        } else {
            $id('pagination-next').style.display = '';
            $id('pagination-previous').style.display = '';
        }
        if(pages == 1) {
            $id('pagination-next').style.display = 'none';
            $id('pagination-previous').style.display = 'none';
        }
    });

    $currentPage.classList.remove('active');
    var nextPage;
    if($e.getAttribute('data-id') != '>>' && $e.getAttribute('data-id') != '<<') {
        $e.classList.add('active');
        $currentPage    =   $e;

    } else if($e.getAttribute('data-id') == '>>') {
        nextPage    = parseInt( $currentPage.getAttribute('data-id') ) + 1;
        $currentPage = $id('page-' + nextPage );
        $currentPage.classList.add('active');
    } else if($e.getAttribute('data-id') == '<<') {
        nextPage    = $currentPage.getAttribute('data-id') - 1;
        $currentPage = $id('page-' + nextPage );
        $currentPage.classList.add('active');
    }

    page     = $currentPage.getAttribute('data-id');
    populateApplicationsTable();
}

function replaceContent(element, newContent) {
    element.textContent = newContent;
}

function replaceContentLeaveApplication(leaveApplication) {
    GETLeaveApplicationOwner(leaveApplication.account_id).then(function (response) {
        var first_name  = toTitleCase(response.employee.first_name);
        var middle_name = toTitleCase(response.employee.middle_name);
        var last_name   = toTitleCase(response.employee.last_name);
        replaceContent($applicantName, first_name + " " + middle_name + " " + last_name);
        replaceContent($applicantSchool, response.school.school_name);
    });
    replaceContent($numberDaysApplied,  leaveApplication.number_days_applied);
    replaceContent($fromDate,           formatDate(leaveApplication.from_date));
    replaceContent($placeStay,          (placeStay(leaveApplication.place_stay, leaveApplication.place_stay_specify)) );
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

function placeStay(placeStay, placeStaySpecify){
    if(placeStay > " " && placeStaySpecify > " ") {
        place = placeStay.split("_");
        newPlaceStay = "";
        for (roll = 0; roll < place.length; roll++) {
            newPlaceStay += place[roll][0].toUpperCase() + place[roll].slice(1) + " ";
        }
        return newPlaceStay + ", " + placeStaySpecify;
    } else if(placeStaySpecify > " ") {
        return placeStaySpecify;
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
        replaceContentSDS(actionOnApplication['division_head_approved'], actionOnApplication['action_on_application']);
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
            if(action.disapproved_due_to > " ") {
                $reason.textContent = action.disapproved_due_to;
                $reasonHolder.style.display = "";
            }
            rejected = true;
            rejectedBy = $element.id;
        } else if( approved == 1 ) {
            $element.className ="primary-font";
            $action.textContent = "Accepted!";
            if(action.approved_for > " ") {
                $reason.textContent = action.approved_for;
                $reasonHolder.style.display = "";
            }
            next = true;
        }
    } else {
        $element.className = "info-font";
        $action.textContent = "No Response Yet!";
    }

    return next;
}

function addPagination() {
    leaveApplicationCountPromise = GETLeaveApplicationCount().then(function (result) {
        var totalPages          = Math.ceil( result.total / 10 );
        var $previous           = createPageButton('<<', 'pagination-previous');
        $previous.style.display = "none";
        $pagination.appendChild( $previous );
        for (var roll = 1; roll <= totalPages; roll++) {
            var $a = createPageButton(roll);
            $pagination.appendChild( $a );

            if(roll == 1) {
                $currentPage = $a;
                $currentPage.className = $currentPage.className + ' active';
            }
        }
        var $next   = createPageButton('>>', 'pagination-next');
        if(totalPages <= 1) {
            $next.style.display = 'none';
        }
        $pagination.appendChild( $next );
        return result;
    });
}

function openRespondModal() {
    $respondModal.style.display = 'block';
}

function openReverseActionModal() {
    $reverseActionModal.style.display = 'block';
    reverseActionNow = true;
}

function emptyPagination() {
    $pagination.innerHTML = "";
}

function removeActive() {
    $newApplications.classList.remove('active');
    $acceptedApplications.classList.remove('active');
    $rejectedApplications.classList.remove('active');
} 