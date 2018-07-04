<section class="modal-section">
    <div id="create-account-modal" class="modal" style="display: none;">
        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <h6 id="modal-title" class="text-center">Create Account</h6>
            <hr>
            <form id="add-account-form">
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
                                Employee Name:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <input type="text" id="create-employee-name" placeholder="Search Employee Name" list="employees" autocomplete="off" required>
                        </td>
                    </tr>

                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Account Type:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <select id="create-account-type">
                                <option value="1">User</option>
                                <option value="2">Principal</option>
                                <option value="3">Human Resource</option>
                                <option value="4">Division Superintendent</option>
                                <option value="5">Account Manager</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Account Username:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <input type="text" id="create-username" placeholder="Username" required>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Password:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <input type="password" id="create-password" placeholder="Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Confirm Password:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <input type="password" id="create-password-confirm" placeholder="Confirm Password" required>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="" id="message" style="display: none; margin-top: 0; padding-left: 20%;">
                </div>

                <hr>
                <div style="text-align: center;">
                    <button type="submit" class="button button-primary" >Create Account</button>
                    <button class="" onclick="closeModal(this)" type="button">Close</button>
                </div>

            </form>
        </div>
    </div>

    <div id="edit-account-modal" class="modal" style="display: none;">
        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <h6 id="modal-title" class="text-center">Edit Account</h6>
            <hr>
            <form id="edit-account-form">
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
                                Employee Name:
                            </div>
                        </td>
                        <td style="border:0; padding-bottom: 20px;" id="edit-employee-name">
                            Christian Luceno Garillo
                        </td>
                    </tr>

                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Username:
                            </div>
                        </td>
                        <td style="border:0; padding-bottom: 20px;" id="edit-username">
                            TheUsername
                        </td>
                    </tr>

                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Account Type:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <select id="edit-account-type">
                                <option value="1">User</option>
                                <option value="2">Principal</option>
                                <option value="3">Human Resource</option>
                                <option value="4">Division Superintendent</option>
                                <option value="5">Account Manager</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Password:
                            </div>
                        </td>

                        <td style="border:0; padding-bottom: 20px; color: #007bff; cursor: pointer;" id="change-password-action">
                            <u>Change</u>
                        </td>

                        <td style="border:0; display: none;" id="edit-password-holder">
                            <input type="password" id="edit-password" placeholder="Password">
                        </td>
                    </tr>

                    <tr id="edit-confirm-password-holder" style="display: none">
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Confirm New Password:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <input type="password" id="edit-password-confirm" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr id="cancel-edit-password-holder" style="display: none;">
                        <td  style="border:0;">
                            <div class="float-right bold">
                            </div>
                        </td>
                        <td style="border:0; padding-bottom: 20px; color: #007bff; cursor: pointer;" id="cancel-change-password-action">
                            <u>Cancel Change Password</u>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <div class="" id="edit-message" style="display: none; margin-top: 0; padding-left: 20%;">
                </div>

                <hr>
                <div style="text-align: center;">
                    <button type="submit" class="button button-primary" >Save Changes</button>
                    <button class="" onclick="closeModal(this)" type="button">Close</button>
                </div>

            </form>
        </div>
    </div>

    <div id="confirm-action-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="modal-title">Create Account?</h5>

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

    <div id="confirm-edit-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="modal-title">Submit Changes?</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button class="button-danger"  id="confirm-edit-action">Confirm</button>
                        <button class="button-primary" onclick="closeModal(this)">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="success-modal" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Successfully Created New Account!</h5>

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

</section>
