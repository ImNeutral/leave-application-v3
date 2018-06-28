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
</head>
<body>

<div id="loader-container" class="loader-container">
    <div class="loader"></div>
</div>

<div class="view-photo" id="view-photo" style="display: none;">
    <span class="close" id="close-view-photo" onclick="closeViewPhoto(this)" style="margin-right: 50px;">&times;</span>
    <img src="" alt="Image" id="photo">
</div>

<?php include ('modals/change-password-modal.php'); ?>