var $oldPassword    = $id('old-password');
var $newPassword    = $id('new-password');
var $newPassword2   = $id('new-password2');


var $viewProfileModal       = $id('view-profile-modal');
var $profilePicture         = $id('profile-picture');

var $changePasswordModal    = $id('change-password-modal');
var $changePasswordSuccess  = $id('change-password-success');

var $errorChangePassword    = $id('error-change-password');

var $submitNewProfilePicture        = $id('submit-new-profile-picture');
var $profileUpload                  = $id('profile-upload');
var $profileUploadValue             = "";

$submitNewProfilePicture.addEventListener('click', function () {
    POSTProfilePicture().then(function () {
        $id('change-profile-picture-success').style.display = "block";
    });
    $viewProfileModal.style.display = "none";
});

$profileUpload.addEventListener('change', function (e) {
    var file  = $profileUpload.files[0];
    var reader  = new FileReader();
    reader.readAsDataURL(file);

    reader.addEventListener("load", function () {
        $profileUploadValue = reader.result;
        // var $image = $id('hiddenImage');
        // $image.src = reader.result;
        // $image.addEventListener("load", function (e) {
        //     $image = e.target;
        //     fileDataURI = imageResizeToNewDataUri($image, $image.width/2, $image.height/2);
        // });
    }, false);
});

function showChangePasswordModal() {
    $changePasswordModal.style.display = "block";
}

function changePassword() {
    checkNewPasswords();
}

function checkNewPasswords() {
    if($newPassword.value == $newPassword2.value && $newPassword.value > '') {
        $errorChangePassword.style.display = 'none';
        $loader.style.display = "block";
        isPasswordCorrect().then(function (response) {
            if(!response) {
                $loader.style.display = "none";
                $errorChangePassword.style.display = 'block';
                $errorChangePassword.innerText = "Wrong old password entered.";
            } else {
                submitNewPassword().then(function (response) {
                    $loader.style.display = "none";
                    $changePasswordSuccess.style.display = "block";
                }, function (err) {
                    fetchFailed();
                });
            }
        }, function (err) {
            fetchFailed();
        });
    } else {
        $errorChangePassword.style.display = 'block';
        $errorChangePassword.innerText = "New password does not match.";
    }
}

function isPasswordCorrect() {
    // var data = toJSONString( $form );
    var url = getHost() + "/leave-application-api-capstone/AccountAPI.php?username=" + accountUsername + "&password=" + $oldPassword.value;
    var init = {
        method: 'GET',
        headers: new Headers({
        })
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function submitNewPassword() {
    var accountObj = {
        'username' : accountUsername,
        'old_password' : $oldPassword.value,
        'new_password' : $newPassword.value
    };
    var accountData = JSON.stringify( accountObj );
    var url = getHost() + "/leave-application-api-capstone/AccountAPI.php";
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: accountData
    };
    return fetch(url, init).then(function(response){
        return response.json();
    });
}

function showViewProfileModal() {
    $viewProfileModal.style.display = "block";
    
    showProfilePicture().then(function (response) {
        $profilePicture.src = response;
    });
}

function showProfilePicture() {

       var url = getHost() + "/leave-application-api-capstone/FileAttachmentAPI.php?filename=" + profilePicture;
       var init = {
           method: 'GET',
           headers: new Headers({
           })
       };
       return fetch(url, init).then(function(response){
           return response.json();
       });
}

function POSTNewProfilePicture($newProfile) {
    var data = JSON.stringify({
        changeProfilePicture: true,
        newProfilePicture   : $newProfile,
        accountId           : accountID
    });
    var url = '../leave-application-api-capstone/AccountAPI.php';
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: data
    };
    return fetch(url, init);
}

function POSTProfilePicture() {
    var filename = "profile-" + randomAttachmentName();
    profilePicture  = filename;

    return POSTNewProfilePicture(profilePicture).then(function (response) {
        var data = JSON.stringify({
            append   : true,
            filename : filename,
            content  : $profileUploadValue
        });

        var url = '../leave-application-api-capstone/FileAttachmentAPI.php';
        var init = {
            method: 'POST',
            headers: new Headers({
            }),
            body: data
        };
        return fetch(url, init);
    });
}