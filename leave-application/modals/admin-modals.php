<section class="modal-section">
    <div id="application-action" class="modal" style="display: none;">

        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <br><br>

            <div  style="overflow: auto; max-height: 350px;">
                <table width="100%" border="0">
                    <thead>
                    <tr>
                        <th width="50%"></th>
                        <th width="50%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Leave Type:
                            </div>
                        </td>
                        <td style="border:0;" id="application-type">_</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Applicant Name:
                            </div>
                        </td>
                        <td style="border:0;" id="applicant-name">_</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Applicant Photo:
                            </div>
                        </td>
                        <td style="border:0; cursor: pointer" id="applicant-photo"><u>View</u></td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Applicant School:
                            </div>
                        </td>
                        <td style="border:0;" id="applicant-school">_</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Days Applied:
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
                        <tr>
                            <th width="50%"></th>
                            <th width="50%"></th>
                        </tr>
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
                                    Remarks:
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
                        <tr>
                            <th width="50%"></th>
                            <th width="50%"></th>
                        </tr>
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
                                    For:
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
                        <tr>
                            <th width="50%"></th>
                            <th width="50%"></th>
                        </tr>
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
                                    For:
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
                <button class="button-danger" onclick="openReverseActionModal()" id="open-reverse-action" >Reverse Action</button>
                <button class="button-primary" onclick="openRespondModal()" id="open-edit-modal">Repond to Application</button>
                <button class="" onclick="closeModal(this)">Close</button>
            </div>
        </div>
    </div>

    <div id="respond-modal" class="modal" style="display: none;">
        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <h6 class="text-center">Respond to Application</h6>

            <div  style="overflow: auto; max-height: 350px;">
                <table width="100%" border="0">
                    <thead>
                    <tr>
                        <th width="50%"></th>
                        <th width="50%"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Response:
                            </div>
                        </td>
                        <td style="border:0;" id="response">
                            <select name="" id="response-type">
                                <option value="1">Accept</option>
                                <option value="0">Reject</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                For:
                            </div>
                        </td>
                        <td style="border:0;" >
                            <input type="text" id="response-reason" placeholder="...">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <div style="text-align: center;">
                <button class="button-primary" id="submit-response">Submit</button>
                <button class="" onclick="closeModal(this)">Close</button>
            </div>
        </div>
    </div>


    <div id="confirm-action-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="confirm-modal-title">Submit Response?</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-danger"  id="confirm-action">Confirm</button>
                        <button class="button-primary" onclick="closeModal(this)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="reverse-action-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" >Reverse Action on this application?</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-danger"  id="confirm-reverse-action">Confirm</button>
                        <button class="button-primary" onclick="closeModal(this)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="reverse-success-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Action Successfully Reversed!</h5>

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

    <div id="respond-success-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Response Sent!</h5>

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

    <div id="connection-back-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" >Connection is back, reload page?</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-danger"  onclick="reloadPage()">Reload</button>
                        <button class="button-primary" onclick="closeModal(this)">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>