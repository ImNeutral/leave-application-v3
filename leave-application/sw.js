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
                    return fetch(event.request);
                }
            )
    );
});