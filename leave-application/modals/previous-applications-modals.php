<section class="modal-section">
    <!-- The Modal -->
    <div id="myModal" class="modal" style="display: none; height: auto;">

        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <h6 id="modal-title" class="text-center">Sick Leave</h6>

            <div  style="overflow: auto; max-height: 350px;">
                <table width="100%" border="0">
                    <thead>
                    <th width="50%"></th>
                    <th width="50%"></th>
                    </thead>
                    <tbody>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Number Of Days Applied:
                            </div>
                        </td>
                        <td style="border:0;" id="number-days-applied">_</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Start Date:
                            </div>
                        </td>
                        <td style="border:0;" id="from-date">_</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Place Stay:
                            </div>
                        </td>
                        <td style="border:0;" id="place-stay">_</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Commutation Requested:
                            </div>
                        </td>
                        <td style="border:0;" id="commutation-requested">_</td>
                    </tr>
                    <tr id="photo-attachment-holder">
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Photo Attachment:
                            </div>
                        </td>
                        <td style="border:0; cursor: pointer;" id="photo-attachment"><u>View</u></td>
                    </tr>
                    </tbody>
                </table>

                <div id="principal" style="display: none;">
                    <table width="100%" border="0" >
                        <thead>
                        <th width="50%"></th>
                        <th width="50%"></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" style="border-bottom: 0;" class="bold text-center" id="title">
                                Principal
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Action:
                                </div>
                            </td>
                            <td style="border:0;" id="action"></td>
                        </tr>
                        <tr id="reason-holder">
                            <td style="border:0;" >
                                <div class="float-right bold">
                                    Reason:
                                </div>
                            </td>
                            <td style="border:0;" id="reason"></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                <div id="hr-department" style="display: none;">
                    <table width="100%" border="0">
                        <thead>
                        <th width="50%"></th>
                        <th width="50%"></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" style="border-bottom: 0;" class="bold text-center" id="hr-title">
                                Human Resource Department
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Action:
                                </div>
                            </td>
                            <td style="border:0;" id="action"></td>
                        </tr>
                        <tr id="reason-holder">
                            <td style="border:0;" >
                                <div class="float-right bold">
                                    Reason:
                                </div>
                            </td>
                            <td style="border:0;" id="reason"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div id="sds" style="display: none;">
                    <table width="100%" border="0" >
                        <thead>
                        <th width="50%"></th>
                        <th width="50%"></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" style="border-bottom: 0;" class="bold text-center" id="sds-title">
                                Division Superintendent
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Action:
                                </div>
                            </td>
                            <td style="border:0;" id="action"></td>
                        </tr>
                        <tr id="reason-holder">
                            <td style="border:0;" >
                                <div class="float-right bold">
                                    Reason:
                                </div>
                            </td>
                            <td style="border:0;" id="reason"></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </div>
            <hr>
            <div style="text-align: center;">
                <button class="button-primary" onclick="openEditModal(this)" id="open-edit-modal">Edit Application</button>
                <button class="" onclick="closeModal(this)">Close</button>
            </div>
        </div>

    </div>


    <div id="leave-application-edit-modal" class="modal" style="display: none; height: auto;">
        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 70%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <h6 id="modal-title" class="text-center">Edit Leave Application</h6>

            <form id="edit-leave-application-form">
                <table width="100%" border="0">
                    <thead>
                    <th width="50%"></th>
                    <th width="50%"></th>
                    </thead>
                    <tbody>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Type Of Leave:
                            </div>
                        </td>
                        <td style="border:0;" id="type-of-leave">
                            Type of Leave
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Number Of Days Applied:
                            </div>
                        </td>
                        <td style="border:0;" id="number-days-applied-edit-holder">
                            <input type="number" name="number_days_applied_edit" id="number-days-applied-edit" min="1" max="60" placeholder="1-15" required>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Start Date:
                            </div>
                        </td>
                        <td style="border:0;" id="from-date-edit-holder">
                            <div class="input">
                                <?php $y = date('Y');?>
                                <select name="date_from_year_edit" id="date-from-year-edit" class="four columns columns-sm">
                                    <option value="<?php echo $y-1; ?>"><?php echo $y-1; ?></option>
                                    <option value="<?php echo $y; ?>" selected><?php echo $y; ?></option>
                                    <option value="<?php echo $y+1; ?>"><?php echo $y+1; ?></option>
                                </select>
                                <select name="date_from_month_edit" id="date-from-month-edit" class="five columns columns-sm" onchange="monthChangedFrom()">
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
                                <select name="date_from_day_edit" id="date-from-day-edit" class="three columns columns-sm">
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Place Stay:
                            </div>
                        </td>
                        <td style="border:0;" id="place-stay-edit-holder">
                            <input type="text" name="place_stay_specify_edit" id="place-stay-specify-edit" placeholder="Where will you spend your leave?">
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Commutation Requested:
                            </div>
                        </td>
                        <td style="border:0;" id="commutation-requested-edit-holder">
                            <select name="commutation_requested_edit" id="commutation-requested-edit">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="photo-attachment-holder">
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Photo Attachment:
                            </div>
                        </td>
                        <td style="border:0; cursor: pointer;" id="photo-attachment-edit-holder">
                            <input type="file"  id="file-to-upload-edit" style="margin-left:15px; cursor: pointer;" name="attachment" accept="image/*"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <hr>
                <div style="text-align: center;">
                    <button class="button-primary" type="submit">Save Changes</button>
                    <button class="button-danger" id="cancel-leave-application" type="button">Cancel Application</button>
                    <button class="" onclick="closeModal(this)" type="button">Close</button>
                </div>

            </form>
        </div>
    </div>

    <div id="info-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Successfully Cancelled Application!</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-primary" onclick="closeModal(this)">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirm-cancel-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="confirm-modal-title">Cancel this application?</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-danger"  id="confirm-cancel-application">Confirm</button>
                        <button class="button-primary" onclick="closeModal(this)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="update-success-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Successfully Updated Application!</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-primary" onclick="closeModal(this)">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="view-photo" id="view-photo" style="display: none;">
        <span class="close" id="close-view-photo" onclick="closeViewPhoto(this)" style="margin-right: 50px;">&times;</span>
        <img src="" alt="Image" id="photo">
    </div>

</section>

