var $leaveApplications = $id('previous-applications-list');
var page               = 1;

GET('page', page).then(function (JSONresponse) {
    var num = (page-1) * 10 + 1;

    for(var roll = 0; roll < JSONresponse.length; roll++) {
        var tr              = document.createElement('tr');
        var tdNum           = document.createElement('td');
        var tdType          = document.createElement('td');
        var tdDays          = document.createElement('td');
        var tdFromDate      = document.createElement('td');
        var tdStatus        = document.createElement('td');

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


        tdNum.appendChild(tdNumTN);
        tdType.appendChild(tdTypeTN);
        tdDays.appendChild(tdDaysTN);
        tdFromDate.appendChild(tdFromDateTN);
        tdStatus.appendChild(tdStatusTN);

        tr.className = "dataTR";
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

function GET(type, number) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/LeaveApplicationAPI.php?" + type + "=" + number;
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
    $tr                 = document.querySelectorAll("tr.dataTR");
    $tr.forEach(function ($eachTr) {
        $eachTr.addEventListener("click", function (e) {
            var element = this;
            console.log(element.children[1].textContent);
            modalTitle.textContent = element.children[1].textContent + " Leave";
            modal.style.display = "block";
        });
    });
}