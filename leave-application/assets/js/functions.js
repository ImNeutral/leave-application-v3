function $id(el) {
    return document.getElementById(el);
}

function getHost() {
    return "localhost/leave-application-v3";
}

function getLoginDetails() {
    var LSaccount = JSON.parse(localStorage.getItem("account"));
    var LSemployee = JSON.parse(localStorage.getItem("employee"));

    var loginDetails = [LSaccount, LSemployee];
    return loginDetails;
}

function isLoggedIn() {
    var loginDetails = getLoginDetails();
    return (loginDetails[0]) ? 1 : 0;
}

function logout() {
    localStorage.removeItem('account');
    localStorage.removeItem('employee');
    window.location.assign("login.php");
}

function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt){
        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
}

function isAllowed(id) {
    var currentLoc      = window.location.href.split('/').pop().split('#')[0].split('?')[0];
    var routes = {
        "login.php"                 : "0",
        "change-password.php"       : "0",
        "leave-application.php"     : "1",
        "previous-applications.php" : "1"
    };

    var defaultRoutes = {
        "0" : "login.php",
        "1" : "leave-application.php"
    };

    if(routes[currentLoc] != id) {
        window.location.assign(defaultRoutes[id]);
    }
}

function modalIn(element) {
    element.style.display = 'block';
}

function modalOut(element) {
    element.style.display = 'none';
}
