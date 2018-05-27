if(isLoggedIn()) {
    var loginDetails        = getLoginDetails();

    var accountID           = loginDetails[0].id;
    var accountTypeID       = loginDetails[0].account_type_id;
    var accountUsername     = loginDetails[0].username;

    var employeeID          = loginDetails[1].id;
    var schoolID            = loginDetails[1].school_id;
    var employeeFirstName   = toTitleCase( loginDetails[1].first_name );
    var employeeMiddleName  = toTitleCase( loginDetails[1].middle_name );
    var employeeLastName    = toTitleCase( loginDetails[1].last_name );
    var fullName            = employeeFirstName + " " + employeeMiddleName + " " + employeeLastName;

    isAllowed(accountTypeID);
} else {
    isAllowed(0);
}
