<script>
    var noInternet      = $id('no-internet');
    var connection      = navigator.onLine;

    (function () {
        $id('fullNameDisplay').text = fullName;
    })();

    function dropdownFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    };
    // recall resubmit function inside serviceworker;
    navigator.serviceWorker.controller.postMessage('checkUnSubmittedLeaveApplication');


    if(!connection) {
        noInternet.style.display = "";
    }
    window.addEventListener('online', function () {
        noInternet.style.display = "none";
    });
    window.addEventListener('offline', function () {
        noInternet.style.display = "";
    });

</script>
<script src="assets/js/change-password.js"></script>
</body>
</html>