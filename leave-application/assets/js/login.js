function login() {
    var $errorMessage = document.getElementById('error-message');
    var $successMessage = document.getElementById('success-message');
    var $submitButton = document.getElementById('submit-button');
    $submitButton.innerHTML = "Logging in...";
    var $password = document.getElementById('password');
    var password = $password.value;
    var username = document.getElementById('username').value;

    var url = "http://" + getHost() + "/leave-application-api-capstone/AccountAPI.php?username=" + username + "&password=" + password;

    fetchAccount(url);

    function fetchAccount(url) {
        var FetchAction = fetch(url, {
            method: 'GET'
        });
        FetchAction.then(function(response) {
            if (response.ok) {
                response.json().then(function (jsonRes) {
                    if (jsonRes) {
                        var account = jsonRes[0];
                        var employee = jsonRes[1];

                        localStorage.setItem('account', JSON.stringify(account));
                        localStorage.setItem('employee', JSON.stringify(employee));

                        $errorMessage.style.display = 'none';
                        $successMessage.style.display = 'block';
                        isAllowed(account.account_type_id);
                    } else {
                        $errorMessage.style.display = 'block';
                        $password.value = "";
                        $submitButton.innerHTML = "Login";
                    }
                }).catch(function (error) {
                    console.log("The Error:", error);
                });
            } else {
                console.log("Could not connect to server!");
            }
        });
    }
}
