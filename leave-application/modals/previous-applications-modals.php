<section class="modal-section">
    <!-- The Modal -->
    <div id="myModal" class="modal" style="display: block; height: auto;">

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
                        <td style="border:0;" id="days-applied">12</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Start Date:
                            </div>
                        </td>
                        <td style="border:0;" id="from-date">April 12, 2019</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Place Stay:
                            </div>
                        </td>
                        <td style="border:0;" id="place-stay">In Hospital, Bayugan Doctors Hospital</td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Commutation Requested:
                            </div>
                        </td>
                        <td style="border:0;" id="commutation-requested">No</td>
                    </tr>
                    </tbody>

                    <table width="100%" border="0">
                        <thead>
                        <th width="50%"></th>
                        <th width="50%"></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" style="border-bottom: 0;" class="bold text-center info-font" id="principal-title">
                                Principal
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Approved:
                                </div>
                            </td>
                            <td  style="border:0;" class="info-font" id="principal-approved">Yes</td>
                        </tr>

                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Reason:
                                </div>
                            </td>
                            <td  style="border:0;" id="principal-reason">Reason show if exists. Else, show only Approved above.</td>
                        </tr>
                        </tbody>
                    </table>

                    <table width="100%" border="0">
                        <thead>
                        <th width="50%"></th>
                        <th width="50%"></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" style="border-bottom: 0;" class="bold text-center danger-font" id="hr-title">
                                Human Resource Department
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Approved:
                                </div>
                            </td>
                            <td  style="border:0;" class="danger-font" id="hr-approved">No</td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Reason:
                                </div>
                            </td>
                            <td  style="border:0;" class="danger-font" id="hr-reason">Days not possible to be applied. Please Reapply using 3 days sick leave.</td>
                        </tr>
                        </tbody>
                    </table>

                    <table width="100%" border="0">
                        <thead>
                        <th width="50%"></th>
                        <th width="50%"></th>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="2" style="border-bottom: 0;" class="bold text-center danger-font" id="sds-title">
                                Division Superintendent
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Approved:
                                </div>
                            </td>
                            <td  style="border:0;" class="danger-font" id="sds-approved">No</td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <div class="float-right bold">
                                    Reason:
                                </div>
                            </td>
                            <td  style="border:0;" class="danger-font" id="sds-reason">Days not possible to be applied. Please Reapply using 3 days sick leave.</td>
                        </tr>
                        </tbody>
                    </table>
                </table>

            </div>
            <hr>
            <div style="text-align: center;">
                <button class="button-primary">Edit Application</button>
                <button class="" onclick="closeModal(this)">Close</button>
            </div>
        </div>

    </div>

</section>