<?php require_once ("Controllers/LeaveApplicationController.php"); ?>

<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav-user.php'); ?>
            <h5 class="header">Leave Application</h5>
            <hr>
            <?php if(!$successApplication) { ?>
            <div class="row">
                <form action="" method="POST" class="leave-application" enctype="multipart/form-data">
                    <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Date Filed:
                    </strong>
                        <?php echo date('M d, Y'); ?>
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
                            <strong>Number of working days applied:</strong>
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
                                            <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
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
                                <strong>Attachments:</strong>
                                <br>
                                <button id="loadFileXml" onclick="document.getElementById('fileToUpload').click()" class="three columns">Add Attachments</button>
                                <input type="file" style="display:none;" id="fileToUpload" name="attachment" accept="image/*" multiple/>
                            </div>

                        </section>

                        <div class="two columns u-pull-right">
                            <input type="submit" class="button-primary" name="submit" value="Submit">
                        </div>
                    </div>
            
                </form>
 
            </div>
            <?php } else { ?>
                <div class="error-message four columns offset-by-four" style="margin-top: 5px;">
                    <p style="color: black;">Leave Application Sent!</p>
                    <a href="previous-applications.php" class="button button-primary u-pull-right">View Application History</a>
                </div>
            <?php } ?>
        </div>
    </div>


</section>
<script>
    document.title = "Leave Application | Application Form";
    document.getElementById('leave-application').className = 'active';

    $typeOfLeave        = document.getElementById('type_of_leave');
    $othersReason       = document.getElementById('others_reason_holder');
    $othersReasonInput  = document.getElementById('others_reason');
    $whereLeaveBeSpend  = document.getElementById('where_leave_be_spend_holder');
    $vacationPlace      = document.getElementById('vacation_leave_place_holder');
    $daysAppliedHolder  = document.getElementById('days_applied_holder');
    $daysApplied        = document.getElementById('days_applied');
    $sickPlace          = document.getElementById('sick_leave_place_holder');

    $dateFromYear       = document.getElementById('date_from_year');
    $dateFromMonth      = document.getElementById('date_from_month');
    $dateFromDay        = document.getElementById('date_from_day');

    var typeOfLeave = 'Sick';
    selectDateNow($dateFromMonth, $dateFromDay);

    function selectTypeOfLeave () {
        typeOfLeave = $typeOfLeave.value;
        if(typeOfLeave == 'others' || typeOfLeave == 'vacation-others') {
            $othersReasonInput.removeAttribute('disabled')
            $othersReason.style.opacity = '1';
        } else {
            $othersReasonInput.setAttribute('disabled', 'true');
            $othersReason.style.opacity = '.1';
        }

        if(typeOfLeave == 'Sick' || typeOfLeave == 'vacation-employment' || typeOfLeave == 'vacation-others') {
            $whereLeaveBeSpend.style.display = 'block';
            
            if(typeOfLeave == 'Sick') {
                $sickPlace.style.display = 'block';
                $vacationPlace.style.display = 'none';
            }

            if(typeOfLeave == 'vacation-employment' || typeOfLeave == 'vacation-others') {
                $vacationPlace.style.display = 'block';
                $sickPlace.style.display = 'none';
            }

        } else {
            $whereLeaveBeSpend.style.display = 'none';
        }

        if(typeOfLeave == 'Maternity') {
            $daysAppliedHolder.style.display = 'none';
            $daysApplied.setAttribute('disabled', 'true');
        } else {
            $daysAppliedHolder.style.display = 'block';
            $daysApplied.removeAttribute('disabled');
        }

    }

    function monthChangedFrom() {
        setDayValue($dateFromYear.value, $dateFromMonth.value, $dateFromDay);
    }

    function setDayValue(year, month, $day){
        var daysVal     = [31,( (year%4 > 0)? 28: 29 ), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var $optionElement = document.createElement('option');

        while($day.childNodes[0]) {
            $day.removeChild($day.childNodes[0]);
        }

        for(var i = 1; i <= daysVal[month-1]; i++) {
            var $textNode = document.createTextNode(i);
            var $optionElementClone = $optionElement.cloneNode(true);
            $optionElement.value = i;
            $optionElementClone.appendChild($textNode);
            $day.appendChild($optionElementClone)
        }
    }

    function selectDateNow($month, $day) {
        var dateNow     = new Date();
        $month.value = dateNow.getMonth() + 1;
        monthChangedFrom();
        $day.value = dateNow.getDate();
    }

</script>
<?php include ('layouts/footer.php');?>
