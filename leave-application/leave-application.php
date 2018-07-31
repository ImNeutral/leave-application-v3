<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>
<?php include ('modals/leave-application-modals.php'); ?>


<section class="hidden">
    <img id="hiddenImage" src="" alt="" />
</section>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav-user.php'); ?>
            <h6 class="header">Leave Application</h6>
            <hr>

            <div class="row text-center" id="submitting-offline-message" style="display: none;">

                <div class="error-message" id="success-message" style="display: block; ">
                    Submitting/Updating Leave Application, please connect to internet and wait...
                </div>
            </div>

            <div class="row" id="form-container">
                <form action="" method="POST" class="leave-application" id="leave-application-form">
                    <input type="hidden" name="account_id" id="account_id">
                    <input type="hidden" name="school_id" id="school_id">

                    <strong style="margin-left: 10%;">
                        Date Filed:
                    </strong>
                    <datefilled id="date-filled">....</datefilled>

                    <br><br>
                    <div class="row container bigger">
                        <div class="seven columns">
                            <strong>Type of leave:</strong>
                            <select name="type_of_leave" id="type_of_leave" class="twelve columns" onchange="selectTypeOfLeave()">
                                <option value="Sick">Sick</option>
                                <option value="Maternity">Maternity</option>
                                <option value="others">Others (Specify)</option>
                                <optgroup label="Vacation">
                                    <option value="vacation-employment">To Seek Employment</option>
                                    <option value="vacation-others">Vacation - Others (Specify)</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="five columns" id="days_applied_holder">
                            <strong>Number of days applied:</strong>
                            <input type="number" name="days_applied" id="days_applied" min="1" max="15" placeholder="1-15" required>
                        </div>
                        <div class="twelve columns others-reason-style" id="others_reason_holder">
                            <strong>Others (Specify)</strong>
                            <input type="text" name="others_reason" id="others_reason" placeholder="Specify reasons for leave" maxlength="150" disabled required>
                        </div>
                        <div class="twelve columns">
                            <div class="seven columns">
                                <div class="nine columns">
                                    <strong>Effective From (y-m-d):</strong>
                                    <div class="ten columns offset-by-two">

                                        <?php $y = date('Y');?>
                                        <select name="date_from_year" id="date_from_year" class="four columns columns-sm">
                                            <option value="<?php echo $y-1; ?>"><?php echo $y-1; ?></option>
                                            <option value="<?php echo $y; ?>" selected><?php echo $y; ?></option>
                                            <option value="<?php echo $y+1; ?>"><?php echo $y+1; ?></option>
                                        </select>
                                        <select name="date_from_month" id="date_from_month" class="four columns columns-sm" onchange="monthChangedFrom()">
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                        <select name="date_from_day" id="date_from_day" class="four columns columns-sm">
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <section id="where_leave_be_spend_holder">
                            <div class="twelve columns" style="margin-top: 20px;">
                                <strong>Place to spend your leave</strong>
                            </div>
                            <div class="twelve columns" id="vacation_leave_place_holder" style="display: none;">
<!--                                <strong>VACATION LEAVE:</strong>-->
                                <div class="twelve columns">
                                    <input type="radio" name="place" value="within_philippines" class="one columns columns-sm">Within The Philippines
                                </div>
                                <div class="twelve columns">
                                    <input type="radio" name="place" value="abroad" class="one columns columns-sm">Abroad (Specify)
                                    <br>
                                    <input type="text" name="abroad_specify" placeholder="Abroad (Specify)" class="six columns">
                                </div>
                            </div>
                            <div class="twelve columns" id="sick_leave_place_holder">
<!--                                <strong>SICK LEAVE:</strong>-->
                                <div class="twelve columns">
                                    <input type="radio" name="place" value="in_hospital" class="one columns columns-sm">In Hospital
                                    <br>
                                    <input type="text" name="in_hospital_specify" class="six columns" placeholder="Which hospital">
                                </div>
                                <div class="twelve columns">
                                    <input type="radio" name="place" value="out_patient" class="one columns columns-sm">Out Patient
                                    <br>
                                    <input type="text" name="out_patient_specify" class="six columns" placeholder="Where">
                                </div>
                            </div>

                            <div class="twelve columns">
                                <strong>Commutation:</strong>
                                <br>
                                <div class="twelve columns">
                                    <input type="radio" name="commutation_requested" value="1" class="one columns columns-sm">Requested
                                </div>
                                <div class="twelve columns">
                                    <input type="radio" name="commutation_requested" value="0" class="one columns columns-sm">Not Requested
                                </div>
                            </div>

                            <div class="twelve columns">
                                <br>
                                <strong style="float: left;">Image Attachment:</strong>
<!--                                <label for="fileToUpload"><u style="margin-left:15px; cursor: pointer;">Upload Image</u></label>-->
                                <input type="file"  id="fileToUpload" style="margin-left:15px; cursor: pointer;" class="four columns" name="attachment" accept="image/*"/>
                            </div>

                        </section>

                        <div class="two columns u-pull-right">
                            <input type="submit" class="button-primary" name="leave_submit" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>


<script src="assets/js/leave-application.js"></script>
<?php include ('layouts/footer.php');?>
