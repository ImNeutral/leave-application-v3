function login() {
    var $errorMessage = document.getElementById('error-message');
    var $successMessage = document.getElementById('success-message');
    var $submitButton = document.getElementById('submit-button');
    $submitButton.innerHTML = "Logging in...";
    var $password = document.getElementById('password');
    var password = $password.value;
    var username = document.getElementById('username').value;

    var url = "http://localhost/leave-application-api-capstone/AccountAPI.php?username=" + username + "&password=" + password;

    fetchAccount(url);

    function fetchAccount() {
        var FetchAction = fetch(url)
        FetchAction.then(function(response) {
            if (response.ok) {
                response.json().then(function (jsonRes) {
                    var account  = jsonRes[0];
                    var employee = jsonRes[1];
                    console.log(account, employee);
                });
                return true;
            } else {
                return false;
            }
        });
    }

    // var xmlhttp = new XMLHttpRequest();
    // xmlhttp.onreadystatechange = function() {
    //     if (this.readyState == 4 && this.status == 200) {
    //         var result = JSON.parse(this.responseText);
    //         if(result) {
    //             $errorMessage.style.display = 'none';
    //             $successMessage.style.display = 'block';
    //             window.location.assign("/leave-application/manage-accounts.php");
    //         } else {
    //             $errorMessage.style.display = 'block';
    //             $password.value = "";
    //             $submitButton.innerHTML = "Login";
    //         }
    //     }
    // };
    //
    // xmlhttp.open("GET", "http://localhost/leave-application-api-capstone/AccountAPI.php?username=" + username + "&password=" + password, true);
    // xmlhttp.setRequestHeader("Content-type","application/json");
    // xmlhttp.send();
}
