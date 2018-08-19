
<header class="top-nav">
    <div class="row">
        <div class="u-pull-right dropdown dropbtn" onclick="dropdownFunction()">
            <a href="#" class="user-name dropbtn" id="fullNameDisplay"> Test Name </a>
            &nbsp;
            <img src="assets/images/caret-down.png" alt="" class="dropbtn" width="12px">
            <div id="myDropdown" class="dropdown-content">
                <a onclick="showViewProfileModal()">View Profile Picture</a>
                <a onclick="showChangePasswordModal()">Change Password</a>
                <a onclick="logout()">Logout</a>
            </div>
        </div>
    </div>
</header>