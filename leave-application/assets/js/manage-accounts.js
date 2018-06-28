var $loader                 = $id('loader-container');
var $accountsList           = $id('accounts-list');
var $search                 = $id('search');
var $searchBy               = $id('search-by');
var $schools                = $id('schools');

var schools                 = [];
var selectedSchoolId        = 0;

populateSchoolsList();

$searchBy.addEventListener('change', function () {
    if($searchBy.value == 'school') {
        $search.setAttribute('list', 'schools');
        $search.setAttribute('placeholder', 'Search By School');
    } else {
        $search.removeAttribute('list');
        $search.setAttribute('placeholder', 'Search Username');
    }
});

$search.addEventListener('change', function () {
    selectedSchoolId = schools[$search.value];
});

function populateSchoolsList() {
    empty($schools);
    GETSchools().then(function (response) {
        for (var roll = 0; roll < response.length; roll++) {
            var $op = document.createElement('option');
            $op.value   = response[roll].school_name;
            $schools.appendChild($op);
            schools[ response[roll].school_name ] = response[roll].id;
        }
    });
}

function GETSchools() {
    var url = "http://" + getHost() + "/leave-application-api-deped/SchoolAPI.php?all=true";
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}