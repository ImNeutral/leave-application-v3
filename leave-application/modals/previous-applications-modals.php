<section class="modal-section">
    <!-- The Modal -->
    <div id="myModal" class="modal" style="display: none; height: auto;">

        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close">&times;</span>
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
                <button class="button-primary">Edit Application</button>
                <button class="" onclick="closeModal(this)">Close</button>
            </div>
        </div>

    </div>
    
    <div class="view-photo" id="view-photo" style="display: none;">
        <span class="close" id="close-view-photo" onclick="closeViewPhoto(this)" style="margin-right: 50px;">&times;</span>
        <img src="" alt="Image" id="photo">
    </div>

</section>