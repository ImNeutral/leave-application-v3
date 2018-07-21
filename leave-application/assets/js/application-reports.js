var $loader                     = $id('loader-container');
var $pagination                 = $id('pagination');

var $applicationsList           = $id('applications-list');
var $applicationsTable          = $id('applications');

var $year                       = $id('year');
var $month                      = $id('month');
var $day                        = $id('day');

var $printGo                    = $id('print-go');

var $currentPage;

var leaveApplicationsByDay      = [];
var leaveApplications           = [];
var page                        = 1;
var currentTotalPages           = 0;

var leaveApplicationsPromise;

$year.addEventListener('change', function () {
    $month.value = 0;
    empty($day);
    dayDefault();
    $printGo.style.display = "none";
});

$month.addEventListener('change', function () {
   monthChanged();
   $loader.style.display = "block";
   leaveApplicationsPromise = GETLeaveApplications($year.value, $month.value).then(function (response) {
       page = 1;
       setLeaveApplications(response);
       populateApplicationsTable(response);
       addPagination(response.length);
       $loader.style.display = "none";

       showPrintButton(response.length);

       return response;
   }, function (err) {
       fetchFailed();
       $month.value = 0 ;
   });
});

$day.addEventListener('change', function () {
    dayChanged(1);
});

$printGo.addEventListener('click', function () {
    var leaveApplicationsCopy   = [];
    if(parseInt($day.value) > 0) {
        leaveApplicationsCopy = leaveApplicationsByDay;
    } else {
        leaveApplicationsCopy = leaveApplications;
    }

    var $printableTable = printableTable();
    var $printable      = $printableTable.querySelector('#applications-list');
    var title           = "Print Applications";
    var content         = "";
    content             += '<html><head><title>' + title + '</title>';
    content             += '<link rel="stylesheet" type="text/css" href="assets/css/style.css"></head>';
    content             += '<body>';

    var roll = 0;
    for (; roll < leaveApplicationsCopy.length; roll++) {
        $printable.appendChild( createTR(leaveApplicationsCopy[roll], roll) );

        if( (roll + 1) % 25 == 0) {
            content             += '<p class="header">Leave Applications Report: ' + getSelectedDate() + '</p>';
            content         += $printableTable.outerHTML;
            content         += '<div class="page-break"></div>';
            empty($printable);
        }
    }

    if(roll < 24 && roll != 0) {
        content             += '<p class="header">Leave Applications Report: ' + getSelectedDate() + '</p>';
        content             += $printableTable.outerHTML;
    } else if( (roll+1) % 25 != 0 && roll > 24) {
        content             += '<p class="header">Leave Applications Report: ' + getSelectedDate() + '</p>';
        content         += $printableTable.outerHTML;
        content         += '<div class="page-break"></div>';
    } else if(roll == 0) {
        var tr_          = document.createElement('tr');
        var td           = document.createElement('td');
        var tdTN         = document.createTextNode("No Applications.");
        td.colSpan = 5;
        td.className = "text-center";
        td.appendChild(tdTN);
        tr_.appendChild(td);
        $printable.appendChild(tr_);
        content             += '<p class="header">Leave Applications Report: ' + getSelectedDate() + '</p>';
        content             += $printableTable.outerHTML;
    }

    content         += '</body>';
    content         += '<script>window.print(); window.close();</script>';
    content         += '</html>';

    newWin= window.open('');
    newWin.document.write( content );
});

function createTR(_leaveApplication, roll) {
    var tr              = document.createElement('tr');

    var tdNum           = document.createElement('td');
    var tdApplicant     = document.createElement('td');
    var tdType          = document.createElement('td');
    var tdDays          = document.createElement('td');
    var tdStart         = document.createElement('td');

    var tdNumTN           = document.createTextNode( roll + 1 );
    var tdApplicantTN     = document.createTextNode( _leaveApplication.applicant_name );
    var tdTypeTN          = document.createTextNode( _leaveApplication.type_of_leave );
    var tdDaysTN          = document.createTextNode( _leaveApplication.number_days_applied );
    var tdStartTN         = document.createTextNode( formatDate2(_leaveApplication.from_date) );

    tdNum.appendChild(tdNumTN);
    tdApplicant.appendChild(tdApplicantTN);
    tdType.appendChild(tdTypeTN);
    tdDays.appendChild(tdDaysTN);
    tdStart.appendChild(tdStartTN);

    tr.className = "dataTR cursor-default";
    tr.appendChild(tdNum);
    tr.appendChild(tdApplicant);
    tr.appendChild(tdType);
    tr.appendChild(tdDays);
    tr.appendChild(tdStart);

    return tr;
}

function setLeaveApplications(response) {
    leaveApplications = response;
}

function getSelectedDate() {
    var months  = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var date    = "";
    var year    = parseInt($year.value);
    var month   = months[parseInt($month.value)];
    var day     = parseInt($day.value);
    if(day > 0) {
        date        = month + " " + day + ", " + year;
    } else {
        date        = month + " " + year;
    }
    return date;
}

function dayChanged(pageNow) {
    if(parseInt($day.value) > 0) {
        leaveApplicationsByDay = [];
        leaveApplicationsPromise.then(function (response) {
            page = pageNow;
            for (var roll = 0; roll < response.length; roll++) {
                var date    = new Date(response[roll].from_date);
                if( parseInt($day.value) == date.getDate() ) {
                    leaveApplicationsByDay.push(response[roll]);
                }
            }
            setLeaveApplicationsByDay(leaveApplicationsByDay);
            populateApplicationsTable(leaveApplicationsByDay);
            if(page == 1) {
                addPagination(leaveApplicationsByDay.length);
            }
            showPrintButton(leaveApplicationsByDay.length);
        });
    } else {
        page = pageNow;
        leaveApplicationsPromise.then(function (response) {
            populateApplicationsTable(response);
            if(page == 1) {
                addPagination(response.length);
            }
            showPrintButton(response.length);
        });
    }
}

function showPrintButton(length) {
    if(length == 0) {
        $printGo.style.display = "none";
    } else {
        $printGo.style.display = "";
    }
}

function printableTable() {
    var $printableTable = $applicationsTable.cloneNode(true);
    empty($printableTable.querySelector('#applications-list'));

    return $printableTable;
}

function setLeaveApplicationsByDay(_leaveApplicationsByDay) {
    leaveApplicationsByDay = _leaveApplicationsByDay;
}

function populateApplicationsTable(applications) {
    empty($applicationsList);

    if(applications.length <= 0) {
        var tr_          = document.createElement('tr');
        var td           = document.createElement('td');
        var tdTN         = document.createTextNode("No Applications Found!");
        td.colSpan = 5;
        td.className = "text-center";
        td.appendChild(tdTN);
        tr_.appendChild(td);
        $applicationsList.appendChild(tr_);
    }

    var start   = (page - 1) * 10;
    var end     = start + 10;
    if(end > applications.length) {
        end = applications.length;
    }
    for (var roll = start; roll < end; roll++) {
        $applicationsList.appendChild( createTR(applications[roll], roll) );
    }
}

function monthChanged() {
    setDayValue($year.value, $month.value, $day);
    dayDefault();
}

function dayDefault() {
    var $optionElement              = document.createElement('option');
    var $textNode                   = document.createTextNode('-Day-');
    var $optionElementClone         = $optionElement.cloneNode(true);
    $optionElementClone.selected    = 'true';
    $optionElementClone.appendChild($textNode);
    $day.appendChild($optionElementClone);
}

function GETLeaveApplications(year, month) {
    var url = getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php?";
    url     += "year=" + year;
    url     += "&month=" + month;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function clickedPageButton($e) {
    var pages = currentTotalPages;

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

    dayChanged(page);
}

function addPagination(totalPages) {
    empty($pagination);

    totalPages  = Math.ceil( totalPages / 10 );
    currentTotalPages = totalPages;
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
}