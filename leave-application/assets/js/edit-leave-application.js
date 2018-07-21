var $editLeaveApplicationForm       = $id('edit-leave-application-form');
var $editLeaveApplicationModal      = $id('leave-application-edit-modal');
var $updateSuccessModal             = $id('update-success-modal');
var $confirmCancelModal             = $id('confirm-cancel-modal');
var $numberDaysAppliedEdit          = $id('number-days-applied-edit');

var $typeOfLeave                    = $id('type-of-leave-edit');
var $dateFromYearEdit               = $id('date-from-year-edit');
var $dateFromMonthEdit              = $id('date-from-month-edit');
var $dateFromDayEdit                = $id('date-from-day-edit');

var $placeStaySpecifyEdit           = $id('place-stay-specify-edit');
var $commutationRequestedEdit       = $id('commutation-requested-edit');

var $fileToUploadEdit               = $id('file-to-upload-edit');

var $cancelLeaveApplication         = $id('cancel-leave-application');
var $infoModal                      = $id('info-modal');

var $confirmCancelApplication       = $id('confirm-cancel-application');
var cancelApplication               = false;
var fileDataURI                     = '';

checkUnsubmittedInSW();

$cancelLeaveApplication.addEventListener('click', function () {
    cancelApplication = true;
    $confirmCancelModal.style.display = 'block';
});

$confirmCancelApplication.addEventListener('click', function () {
    if(cancelApplication) {
        leaveApplicationPromise.then(function (JSONLeaveApplication) {
            $loader.style.display                   = "block";
            cancelLeaveApplication(JSONLeaveApplication.id, 1).then(function () {
                $editLeaveApplicationModal.style.display = "none";
                $loader.style.display               = "none";
                $infoModal.style.display            = "block";

                $latestClickedStatus                = $latestClicked.querySelector('#status');
                $latestClickedStatus.textContent    = 'Cancelled';
                $latestClickedStatus.className      = 'danger-font';
                $confirmCancelModal.style.display   = 'none';
            }, function (err) {
                fetchFailed();
            });
            return JSONLeaveApplication;
        });
        cancelApplication = false;
    }
});

$editLeaveApplicationForm.addEventListener('submit', function (e) {
    e.preventDefault();
    $loader.style.display       = "block";
    var $submitForm             = this;
    leaveApplicationPromise.then(function (JSONLeaveApplication) {
        var data = toJSONString(JSONLeaveApplication.id, $submitForm);
        PUTLeaveApplication(data).then(function (response) {
            $latestClickedDays                  = $latestClicked.querySelector('#days');
            $latestClickedFromDate              = $latestClicked.querySelector('#from-date');
            $latestClickedDays.textContent      = response.number_days_applied;
            $latestClickedFromDate.textContent  = formatDate2(response.from_date);
            $updateSuccessModal.style.display   = "block";
            $loader.style.display               = "none";
            $id('file-to-upload-edit').value      = "";
            checkUnsubmittedInSW();
        }, function (err) {
            fetchFailed('fetch-failed-leave-application');
        });
    });
});

$fileToUploadEdit.addEventListener('change', function (e) {
    var file  = $fileToUploadEdit.files[0];
    var reader  = new FileReader();
    reader.readAsDataURL(file);

    reader.addEventListener("load", function () {
        var $image = $id('hidden-image');
        $image.src = reader.result;
        $image.addEventListener("load", function (e) {
            $image = e.target;
            fileDataURI = imageResizeToNewDataUri($image, $image.width/2, $image.height/2);
        });
    }, false);
});


function openEditModal(fromModal) {
    closeModal(fromModal);
    $editLeaveApplicationModal.style.display = "block";
    editLeaveApplication();
}

function editLeaveApplication() {
    leaveApplicationPromise.then(function (JSONLeaveApplication) {
        $dateFrom               = new Date(JSONLeaveApplication.from_date);

        $typeOfLeave.innerText          = JSONLeaveApplication.type_of_leave;
        $numberDaysAppliedEdit.value    = JSONLeaveApplication.number_days_applied;
        $dateFromYearEdit.value         = $dateFrom.getFullYear();
        $dateFromMonthEdit.value        = $dateFrom.getMonth() + 1;
        selectDateNow($dateFromMonthEdit, $dateFromDayEdit);
        $dateFromDayEdit.value          = $dateFrom.getDate();
        $placeStaySpecifyEdit.value     = placeStay(JSONLeaveApplication.place_stay, JSONLeaveApplication.place_stay_specify);
        if(JSONLeaveApplication.commutation_requested == '1') {
            $commutationRequestedEdit.value = 1;
        }
        if(JSONLeaveApplication.cancelled == '1') {
            $cancelLeaveApplication.style.display = "none";
        } else {
            $cancelLeaveApplication.style.display = "";
        }
    });
}

function toJSONString( id, form ) {
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
    obj[ 'id' ] = id;

    // obj[ 'fileDataURI' ] = fileDataURI;
    if(fileDataURI > ' ') {
        obj['attachmentName'] = randomAttachmentName();
        saveAttachmentForLater(obj['attachmentName'], fileDataURI);
    }

    return JSON.stringify( obj );
}

function cancelLeaveApplication(id, cancel) {
    $obj = {
        id : id,
        cancel : cancel
    };
    var $data = JSON.stringify($obj);
    return PUTLeaveApplication($data);
} 

function PUTLeaveApplication(data) {
    // var data = toJSONString( $form );
    var url = getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php";
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

