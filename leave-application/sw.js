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

                return fetch(event.request).then(function (response) {
                    return response;
                }, function (err) {
                    if(requestClone.method == 'POST') {
                        console.log("POST Method");
                        var str = requestClone.url;
                        if( str.search("LeaveApplicationAPI.php") != -1) {
                            var id          = 1;
                            var url         = str;
                            dbDelete(id);
                            requestClone.text().then(function (response) {
                                var data = {
                                    id      : id,
                                    url     : url,
                                    data    : response
                                };
                                dbAdd(data);
                                reSubmitLeaveApplicationUntilFinish();
                            });
                        } else {
                            console.log(str);
                        }
                    }
                });
            })
    );
});

self.addEventListener('message', function (msg) {
    self.registration.showNotification("Successfully submitted Leave Application.", { icon: 'assets/images/icon.ico' });
    if(msg.data == 'checkUnSubmittedLeaveApplication') {
        if(typeof timeoutHolder !== 'undefined') {
            clearInterval(timeoutHolder);
            reSubmitLeaveApplicationUntilFinish();
            console.log("Yeah, kind of..");
        } else {
            reSubmitLeaveApplicationUntilFinish();
        }
    }
});

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
        db.transaction(["leave-applications"], "readwrite")
            .objectStore("leave-applications")
            .delete(key);
    };
}

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

function reSubmitLeaveApplicationUntilFinish() {
    var db;
    timeoutHolder = setInterval(function () {
        openDatabase().onsuccess = function (event) {
            db = event.target.result;
            db.transaction(["leave-applications"])
                .objectStore("leave-applications")
                .get(1)
                .onsuccess = function (event) {
                if( event.target.result ) {
                    var url     = event.target.result.url;
                    var data    = event.target.result.data;
                    resubmitLeaveApplication(url, data).then(function () {
                        self.registration.showNotification("Successfully submitted Leave Application.", { icon: 'assets/images/icon.ico' });
                        dbDelete(1);
                        clearInterval(timeoutHolder);
                    }, function (err) {
                        console.log("Failed to submit... retrying in background...");
                        // reSubmitLeaveApplicationUntilFinish();
                    });
                }
            };
        };
    }, 5000);

}