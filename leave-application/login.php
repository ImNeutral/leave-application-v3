<?php include ('layouts/header.php'); ?>

<section class="section section-loginform">
    <div class="container">
        <div class="row loginform eleven columns offset-by-three">

            <div class="seven columns form-container">
                <form action="#" method="POST" class="loginform-contents" id="login-form" onsubmit="return false">
                    <h4>Please Login</h4>
                    <div>
                        <label>Username:</label>
                        <input type="text" class="u-full-width" id="username">
                    </div>
                    <div>
                        <label>Password:</label>
                        <input type="password" class="u-full-width" id="password">
                    </div>
                    <div>
                        <button type="submit" class="button-primary u-pull-right" id="submit-button">Login</button>
                    </div>
                </form>
                <div class="error-message danger" id="error-message" style="display: none;">
                    Username and Password do not match!
                </div>
                <div class="error-message" id="success-message" style="display: none;">
                    Logging in, please wait...
                </div>
            </div>
        </div>
    </div>
</section>
<script src="assets/js/login.js"></script>
<script>
    (function(){
        var $loginForm = document.getElementById('login-form');

        if($loginForm.addEventListener){
            $loginForm.addEventListener("submit", login, false);  //Modern browsers
        }else if($loginForm.attachEvent){
            $loginForm.attachEvent('onsubmit', login);            //Old IE
        }
        document.body.className += 'login-body';

        registerServiceWorker();
    })();
</script>

</body>
</html>