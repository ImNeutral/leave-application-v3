var CACHE_NAME                      = 'sw-tester-v2';
var DB_VERSION                      = 8;
var thereWasFileAttachmentCursor    = false;
var thereWasLeaveApplication        = false;
var resubmitCheckerContinue         = true;
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
                return fetch(event.request).then(function (response) {
                    if( requestClone.method == 'POST' && requestClone.url.search("LeaveApplicationAPI.php") != -1) { // POST to Leave Appplication API but success
                        thereWasFileAttachmentCursor = false;
                        submitFileAttachments();
                    }
                    return response;
                }, function (err) {
                    if(requestClone.method == 'POST') {
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
                            console.log("POST is from PUT. ^_^");
                        }
                    } else {
                        console.log("PUT/DELETE Failed. No Internet.", err);
                    }
                });
            })
    );
});

self.addEventListener('message', function (msg) {
    if(msg.data == 'checkUnSubmittedLeaveApplication') {
        if( typeof timeoutHolder === 'undefined') {
            console.log("Timeout Holder is called...");
            if( typeof fileAttachmentsInterval !== 'undefined' ) {
                clearInterval(fileAttachmentsInterval);
            }

            reSubmitLeaveApplicationUntilFinish();
        }
    }
});

function createDatabase() {
    if( indexedDB ) {
        var request;
        request = indexedDB.open("LeaveApplication", DB_VERSION);

        request.onupgradeneeded = function (event) {
            var db = event.target.result;
            db.createObjectStore("leave-applications", { keyPath: "id" } );
            db.createObjectStore("file_attachments", { keyPath: "id" } );
        };
    }
}

function openDatabase() {
    if( indexedDB ) {
        return indexedDB.open("LeaveApplication", DB_VERSION);
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
                            dbDelete(1);
                            clearInterval(timeoutHolder);
                            self.registration.showNotification("Successfully submitted Leave Application. Checking attachments", { icon: 'assets/images/icon.ico' });
                            submitFileAttachments();
                        }, function (err) {
                            console.log("Failed to submit... retrying in background...");
                        });
                    } else {
                        clearInterval(timeoutHolder);
                        thereWasFileAttachmentCursor = false;
                        submitFileAttachments();
                    }
            };
        };
    }, 2000);
}

function submitFileAttachments() {
    resubmitCheckerContinue = true;

    fileAttachmentsInterval = setInterval(function () {

        if(resubmitCheckerContinue) {
            resubmitCheckerContinue = false;

            openDatabase().onsuccess = function (event) {
                var db = event.target.result;
                var request = db.transaction(["file_attachments"], "readwrite")
                    .objectStore("file_attachments");

                request.openCursor().onsuccess = function (event) {
                    var cursor = event.target.result;
                    if (cursor) {
                        thereWasFileAttachmentCursor = true;
                        var data = {
                            append: true,
                            filename: cursor.value.filename,
                            content: cursor.value.content
                        };
                        var key = cursor.value.id;

                        POSTAppendFileAttachment(data).then(function () {
                            dbDeleteFileAttachments(key);
                            setResubmitContinue();
                        }, function (err) {
                            setResubmitContinue();
                        });
                    } else {
                        if (thereWasFileAttachmentCursor) {
                            self.registration.showNotification("Successfully submitted File Attachment.", { icon: 'assets/images/icon.ico' });
                        }
                        resubmitCheckerContinue = false;
                        clearInterval(fileAttachmentsInterval);
                    }
                }
            };
        }

    }, 200);
}

function setResubmitContinue() {
    resubmitCheckerContinue = true;
    console.log("Resubmit value ", resubmitCheckerContinue);
}

function POSTAppendFileAttachment(data) {
    data = JSON.stringify(data);

    var url = '../leave-application-api-capstone/FileAttachmentAPI.php';
    var init = {
        method: 'POST',
        headers: new Headers({
        }),
        body: data
    };
    return fetch(url, init);
}

function dbDeleteFileAttachments(key) {
    var db;
    openDatabase().onsuccess = function (event) {
        db = event.target.result;
        db.transaction(["file_attachments"], "readwrite")
            .objectStore("file_attachments")
            .delete(key);
    };
}