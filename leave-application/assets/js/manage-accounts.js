var $loader                     = $id('loader-container');
var $accountsList               = $id('accounts-list');
var $createAccountModal         = $id('create-account-modal');
var $editAccountModal           = $id('edit-account-modal');
var $addAccountForm             = $id('add-account-form');
var $editAccountForm            = $id('edit-account-form');
var $confirmActionModal         = $id('confirm-action-modal');
var $confirmEditModal           = $id('confirm-edit-modal');
var $successModal               = $id('success-modal');

var $search                     = $id('search');
var $searchBy                   = $id('search-by');
var $searchGo                   = $id('search-go');
var $searchMessage              = $id('search-message');

var $editMessage                = $id('edit-message');
var $message                    = $id('message');

var $createAccount              = $id('create-account');
var $createEmployeeName         = $id('create-employee-name');
var $createAccountType          = $id('create-account-type');
var $createUsername             = $id('create-username');
var $createPassword             = $id('create-password');
var $createPasswordConfirm      = $id('create-password-confirm');
var $confirmAction              = $id('confirm-action');


var $changePasswordAction       = $id('change-password-action');
var $cancelChangePasswordAction = $id('cancel-change-password-action');
var $editPasswordHolder         = $id('edit-password-holder');
var $editConfirmPasswordHolder  = $id('edit-confirm-password-holder');
var $cancelEditPasswordHolder   = $id('cancel-edit-password-holder');
var $editEmployeeName           = $id('edit-employee-name');
var $editUsername               = $id('edit-username');
var $editAccountType            = $id('edit-account-type');
var $editPassword               = $id('edit-password');
var $editPasswordConfirm        = $id('edit-password-confirm');
var $confirmEditAction          = $id('confirm-edit-action');

var $pagination                 = $id('pagination');

var $currentPage;

var $schools                    = $id('schools');
var $employees                  = $id('employees');

var accountsPromise;
var schools                     = [];
var employees                   = [];
var previousFullNameSearchKey   = "";
var createAccountSubmittable    = false;
var editAccountSubmittable      = false;
var currentTotalPages           = 0;
var page                        = 1;
var submit                      = false;
var clickedAccountId;

populateSchoolsList();

$changePasswordAction.addEventListener('click', function () {
    enableChangePasswordElements(true);
});

$cancelChangePasswordAction.addEventListener('click', function () {
    enableChangePasswordElements(false);
});


$searchBy.addEventListener('change', function () {
    if($searchBy.value == 'school') {
        $search.setAttribute('list', 'schools');
        $search.setAttribute('placeholder', 'Search By School');
    } else {
        $search.removeAttribute('list');
        $search.setAttribute('placeholder', 'Search Username');
    }
});

$searchGo.addEventListener('click', function () {
    var selectedSchoolId = schools[$search.value];
    $searchMessage.style.display = "block";
    if($searchBy.value == 'school') {
        if(selectedSchoolId > -1) {
            $searchMessage.textContent = "Showing results for '" + $search.value + "'";
            accountsPromise = GETSchoolAccounts(selectedSchoolId).then(function (response) {
                populateAccountsTable(response);

                currentTotalPages  = Math.ceil( response.length / 10 );
                addPagination(currentTotalPages);

                return response;
            });
        } else {
            $searchMessage.textContent = "'" + $search.value + "' is not on school list.";
        }
    } else {
        $searchMessage.textContent = "Showing results for '" + $search.value + "'";
        accountsPromise = GETSearchByUsername($search.value).then(function (response) {
            populateAccountsTable(response);

            currentTotalPages  = Math.ceil( response.length / 10 );
            addPagination(currentTotalPages);

            return response;
        });
    }
});

$confirmAction.addEventListener('click', function () {
    submit = true;
    submitCreateAccount();
});

$confirmEditAction.addEventListener('click', function () {
    if(editAccountSubmittable) {
        accountsPromise.then(function (response) {
            var password         = $editPassword.value;
            var accountType      = $editAccountType.value;

            var $obj = {
                account_id           : response[clickedAccountId].account_id,
                account_type_id      : accountType
            };
            if(password > "") {
                $obj[ 'password' ] = password;
            }
            var data = JSON.stringify($obj);
            PUTEditAccount(data).then(function () {
                response[clickedAccountId].account_type_id = accountType;
                populateAccountsTable(response);
                editAccountSubmittable  = false;

                var $messages = [];
                $messages.push("Successfully Saved Changed!");
                showMessage($editMessage, 'success', $messages);
                $confirmEditModal.style.display = "none";
            });
        });
    }
});

$createAccount.addEventListener('click', function () {
    $createAccountModal.style.display = "block";
    // showMessage($message, 'danger', ['*Employee not in the list.', '*Account username already taken.'])
});

$createEmployeeName.addEventListener('keyup', function () {
    var value     = $createEmployeeName.value;
    setTimeout(function () {
        if($createEmployeeName.value == value && value.length > 1) {
            listEmployees();
        }
    }, 800);
});

$addAccountForm.addEventListener('submit', function (form) {
    form.preventDefault();
    var errorMessages      = [];
    if(!employees[$createEmployeeName.value]) {
        errorMessages.push("*Employee is not on employee list!");
    }
    if($createPassword.value != $createPasswordConfirm.value) {
        errorMessages.push("*Passwords do not match!");
    }

    if(errorMessages.length <= 0) {
        $loader.style.display = "block";
        GETSearchByFixedUsername($createUsername.value).then(function (response) {
            if(response > 0) {
                errorMessages.push("*Username already taken!");
            }
            showMessage($message, 'danger', errorMessages);
            if(errorMessages.length <= 0) {
                createAccountSubmittable = true;
                $confirmActionModal.style.display = "block";
                // submitCreateAccount();
            } else {
                createAccountSubmittable = false;
            }
            $loader.style.display = "none";
        }, function (err) {
            fetchFailed();
        });
    }  else {
        showMessage($message, 'danger', errorMessages);
    }
});

$editAccountForm.addEventListener('submit', function (form) {
   form.preventDefault();
   accountsPromise.then(function (response) {
       var errorMessages    = [];
       // response[clickedAccountId]
       if($editPassword.value <= "" && $editAccountType.value == response[clickedAccountId].account_type_id) {
           errorMessages.push("*No Changes Made");
       } else if($editPassword.value != $editPasswordConfirm.value) {
           errorMessages.push("*Passwords do not match!");
       }
       showMessage($editMessage, 'danger', errorMessages);
       if(errorMessages.length <= 0) {
           $confirmEditModal.style.display = "block";
           editAccountSubmittable = true;
       } else {
           editAccountSubmittable   = false;
       }
   });
});

function submitCreateAccount() {
    if(createAccountSubmittable && submit) {
        $loader.style.display = "block";

        var employeeName            = $createEmployeeName.value;
        var employeeId              = employees[employeeName];
        var accountTypeId           = $createAccountType.value;
        var username                = $createUsername.value;
        var password                = $createPassword.value;

        var $obj = {
            employee_id         : employeeId,
            account_type_id     : accountTypeId,
            username            : username,
            password            : password
        };
        var data = JSON.stringify($obj);
        POSTCreateAccount(data).then(function (response) {
            $loader.style.display           = "none";
            createAccountSubmittable         = false;
            submit                          = false;
            $createAccountModal.style.display   = "none";
            $confirmActionModal.style.display   = "none";
            $successModal.style.display         = "block";
        }, function (err) {
            fetchFailed();
        });
        console.log("Hello submit");
    }
}

function listEmployees() {
    var str = $createEmployeeName.value;
    if( str.search(previousFullNameSearchKey) == -1 || previousFullNameSearchKey == '') {
        empty($employees);
        var searchValue     = $createEmployeeName.value;
        GETSearchByEmployeeFullName(searchValue).then(function (response) {
            for (var roll = 0; roll < response.length; roll++) {
                var $op = document.createElement('option');
                var firstName   = toTitleCase( response[roll].first_name );
                var middleName  = toTitleCase( response[roll].middle_name );
                var lastName    = toTitleCase( response[roll].last_name );
                var fullName    = firstName + " " + middleName + " " + lastName;
                $op.value = fullName;
                $employees.appendChild($op);
                employees[fullName] = response[roll].id;
            }
            previousFullNameSearchKey = searchValue;
        });
    }
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

    accountsPromise.then(function (response) {
        populateAccountsTable(response);
    });
}

function populateAccountsTable(accounts) {
    empty($accountsList);

    if(accounts.length <= 0) {
        var tr_          = document.createElement('tr');
        var td           = document.createElement('td');
        var tdTN         = document.createTextNode("No Accounts Found!");
        td.colSpan = 4;
        td.className = "text-center";
        td.appendChild(tdTN);
        tr_.appendChild(td);
        $accountsList.appendChild(tr_);
    }

    var start   = (page - 1) * 10;
    var end     = start + 10;
    if(end > accounts.length) {
        end = accounts.length;
    }
    for (var roll = start; roll < end; roll++) {
        var tr              = document.createElement('tr');
        var tdNum           = document.createElement('td');
        var tdUsername      = document.createElement('td');
        var tdModule        = document.createElement('td');
        var tdOwner         = document.createElement('td');

        var tdNumTN         = document.createTextNode(roll + 1);
        var tdUsernameTN    = document.createTextNode(accounts[roll].username);
        var tdModuleTN      = document.createTextNode(getAccountType(accounts[roll].account_type_id));
        var tdOwnerTN       = document.createTextNode(accounts[roll].fullname);

        tdNum.appendChild(tdNumTN);
        tdUsername.appendChild(tdUsernameTN);
        tdModule.appendChild(tdModuleTN);
        tdOwner.appendChild(tdOwnerTN);

        tr.className = "dataTR";
        tr.appendChild(tdNum);
        tr.appendChild(tdUsername);
        tr.appendChild(tdModule);
        tr.appendChild(tdOwner);

        $accountsList.appendChild(tr);
    }
    addClickEvent();
}

function addClickEvent() {
    var $trClick    = document.querySelectorAll("tr.dataTR");
    $trClick.forEach(function ($eachTr) {
        $eachTr.addEventListener("click", function () {
            var element         = this;
            showMessage($editMessage, '', []);
            enableChangePasswordElements(false);
            clickedAccountId       = (element.children[0].textContent) - 1;
            $editAccountModal.style.display = "block";
            accountsPromise.then(function (response) {
                $editEmployeeName.textContent   = response[clickedAccountId].fullname;
                $editUsername.textContent       = response[clickedAccountId].username;
                $editAccountType.value          = response[clickedAccountId].account_type_id;
            });
        });
    });
}

function populateSchoolsList() {
    empty($schools);
    GETSchools().then(function (response) {
        for (var roll = 0; roll < response.length; roll++) {
            var $op = document.createElement('option');
            $op.value = response[roll].school_name;
            $schools.appendChild($op);
            schools[response[roll].school_name] = response[roll].id;
        }
    });
}

function POSTCreateAccount(data) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/AccountAPI.php";
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

function PUTEditAccount(data) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/AccountAPI.php";
    var init = {
        method: 'PUT',
        headers: new Headers({
        }),
        body: data
    };
    return fetch(url, init).then(function(response){
        return response.json();
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

function GETSchoolAccounts(selectedSchoolId) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/AccountAPI.php?";
    url     += "school_id=" + selectedSchoolId;
    url     += "&employees=true";
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETSearchByUsername(username) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/AccountAPI.php?";
    url     += "username=" + username;
    url     += "&search=true";
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETSearchByFixedUsername(username) {
    var url = "http://" + getHost() + "/leave-application-api-capstone/AccountAPI.php?";
    url     += "username=" + username;
    url     += "&fixed_search=true";
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function GETSearchByEmployeeFullName($name) {
    var url = "http://" + getHost() + "/leave-application-api-deped/EmployeeAPI.php?";
    url     += "searchType=fullName";
    url     += "&name=" + $name;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function addPagination(totalPages) {
    empty($pagination);
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

function enableChangePasswordElements(status) {
    if(status) {
        $changePasswordAction.style.display         = "none";
        $editPasswordHolder.style.display           = "";
        $editConfirmPasswordHolder.style.display    = "";
        $cancelEditPasswordHolder.style.display     = "";
    } else {
        $changePasswordAction.style.display         = "";
        $editPasswordHolder.style.display           = "none";
        $editConfirmPasswordHolder.style.display    = "none";
        $cancelEditPasswordHolder.style.display     = "none";
    }
}