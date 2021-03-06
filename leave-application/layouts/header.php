<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Leave Application | Login</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/icon.ico" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/skeleton.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/loginChecker.js"></script>
    <script>
        if (typeof NodeList !== "undefined" && NodeList.prototype && !NodeList.prototype.forEach) {
            // Yes, there's really no need for `Object.defineProperty` here
            NodeList.prototype.forEach = Array.prototype.forEach;
        }
    </script>
</head>
<body>

<div class="no-internet-container" id="no-internet" style="display: none;">
    <p>No Internet Connection....</p>
</div>

<div id="loader-container" class="loader-container">
    <div class="loader"></div>
</div>

<div class="view-photo" id="view-photo" style="display: none;">
    <span class="close" id="close-view-photo" onclick="closeViewPhoto(this)" style="margin-right: 50px;">&times;</span>
    <div style="overflow: auto;">
        <img src="" alt="Image" id="photo">
    </div>
</div>

<section>
    <div id="fetch-failed" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; color: #721c24; border-color: #f5c6cb; width: 60%;">
            <div style="height: 170px; ">
                <div style="background-color: #f8d7da; margin: -10px;">
                    <span class="close" id="close-cc"></span>
                    <h5 class="text-center info-modal-title" id="info-modal-title" style="font-size: 17px; font-weight: bold;">Transaction Failed, No Connection!</h5>
                    <div class="modal-inside" style="back">
                        <div style="text-align: center; font-size: 16px;">
                            <p>Connect to the internet and do the operation again.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <div style="float:right;">
                    <div>
                        <button class="button-primary" onclick="closeModal(this)">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="fetch-failed-leave-application" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 170px; color: #721c24; border-color: #f5c6cb;  width: 60%;">
            <div style="background-color: #f8d7da; margin: -10px;">
                <span class="close" id="close-cc"></span>
                <h5 class="text-center info-modal-title" id="info-modal-title"  style="font-size: 17px; font-weight: bold;">No Connection!</h5>
                <div class="modal-inside" style="back">
                    <div style="text-align: center; font-size: 16px;">
                        <p>Connect to the internet and wait while the system is redoing the transactions.</p>
                        <hr>
                    </div>
                </div>
            </div>
            <div style="float:right;">
                <a href="leave-application.php">
                    <button class="button-primary" onclick="closeModal(this)">Ok</button>
                </a>
            </div>
        </div>
    </div>


    <div id="connection-lost" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 170px; color: #721c24; border-color: #f5c6cb;  width: 60%;">
            <div style="background-color: #f8d7da; margin: -10px;">
                <span class="close" id="close-cc"></span>
                <h5 class="text-center info-modal-title" id="info-modal-title"  style="font-size: 17px; font-weight: bold;">Connection Lost!</h5>
                <div class="modal-inside" style="back">
                    <div style="text-align: center; font-size: 16px;">
                        <p>When you apply for leave, the system will send it until your back online.</p>
                        <hr>
                    </div>
                </div>
            </div>
            <div style="float:right;">
                <button class="button-primary" onclick="closeModal(this)">Ok</button>
            </div>
        </div>
    </div>

</section>

<?php include ('modals/change-password-modal.php'); ?>