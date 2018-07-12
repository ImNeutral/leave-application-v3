var CACHE_NAME = 'sw-tester-v2';
var resources = [
    'assets/css/normalize.css',
    'assets/css/skeleton.css',
    'assets/css/style.css',
    'assets/images/caret-down.png',
    'assets/images/icon.ico',
    'assets/js/admin-actions.js',
    'assets/js/application-reports.js',
    'assets/js/change-password.js',
    'assets/js/edit-leave-application.js',
    'assets/js/functions.js',
    'assets/js/leave-application.js',
    'assets/js/login.js',
    'assets/js/loginChecker.js',
    'assets/js/manage-accounts.js',
    'assets/js/previous-application.js',
    'admin-actions.php',
    'application-reports.php',
    'change-password.php',
    'create-account.php',
    'edit-account.php',
    'index.php',
    'leave-application.php',
    'login.php',
    'logout.php',
    'manage-accounts.php',
    'previous-applications.php'
];

self.addEventListener('install', function(event) {
    // Perform install steps
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                createDatabase();
                console.log('Opened cache');
                return cache.addAll(resources);
            })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Cache hit - return response
                if (response) {
                    return response;
                }
                var requestClone    = event.request.clone();

                // self.registration.showNotification("Hello this is testing!..");
                testing();

                return fetch(event.request).then(function (response) {
                    return response;
                }, function (err) {
                    if(requestClone.method == 'POST') {
                        console.log("POST Method");
                        var str = requestClone.url;
                        if( str.search("LeaveApplicationAPI.php") != -1) {
                            var id          = 1;
                            var url         = str;
                            var request     = openDatabase();
                            requestClone.text().then(function (response) {
                                var data = {
                                    id      : id,
                                    url     : url,
                                    data    : response
                                };

                                dbAdd(data);
                            });
                        } else {
                            console.log(str);
                        }
                    }
                });
            })
    );
});

// self.addEventListener('message', function (event) {
//     setInterval( function () {
//         console.log("Message From SW, recieve: ", event.data);
//         }, 5000 );
// });


function resubmitLeaveApplication(urlData, bodyData) {
    var url = urlData;
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: bodyData
    };
    return fetch(url, init);
}

function createDatabase() {
    if( indexedDB ) {
        var request;
        request = indexedDB.open("LeaveApplication", 2);

        request.onupgradeneeded = function (event) {
            var db = event.target.result;
            db.createObjectStore("leave-applications", { keyPath: "id" } );
        };
    }
}

function openDatabase() {
    if( indexedDB ) {
        var request;
        return indexedDB.open("LeaveApplication", 2);
    }
}

function dbAdd(data) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"], "readwrite")
            .objectStore("leave-applications")
            .add(data);
    };
}

function dbGet(key) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"])
            .objectStore("leave-applications")
            .get(key)
            .onsuccess = function (event) {
            return event.target.result;
        };
    };
}

function dbDelete(key) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["leave-applications"])
            .objectStore("leave-applications")
            .delete(key);
    };
}