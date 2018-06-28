<section class="change-password-section">

    <div id="change-password-modal" class="modal" style="display: none;">
        <!-- Modal content -->
        <div class="modal-content"  style="margin-top: 5%; width: 60%;">
            <span class="close" onclick="closeModal(this)">&times;</span>
            <h6 id="modal-title" class="text-center">Change Password</h6>

            <form id="">
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
                                Old Password:
                            </div>
                        </td>
                        <td style="border:0;" id="">
                            <input type="password" id="old-password" name="old_password" placeholder="Old Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                New Password:
                            </div>
                        </td>
                        <td style="border:0;" id="number-days-applied-edit-holder">
                            <input type="password" id="new-password" name="new_password" placeholder="New Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td  style="border:0;">
                            <div class="float-right bold">
                                Re-enter New Password:
                            </div>
                        </td>
                        <td style="border:0;" id="number-days-applied-edit-holder">
                            <input type="password" id="new-password2" name="new_password2" placeholder="Re-enter New Password" required>
                        </td>
                    </tr>
                    </tbody>

                </table>
                <div class="error-message danger" id="error-change-password" style="display: none;">
                </div>

                <hr>
                <div style="text-align: center;">
                    <a class="button button-primary" onclick="changePassword()">Change Password</a>
                    <button class="" onclick="closeModal(this)" type="button">Close</button>
                </div>

            </form>
        </div>
    </div>


    <div id="change-password-success" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 200px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Successfully changed your password!</h5>
            <div class="modal-inside">
                <div style="text-align: center;">
                    <p>Please re-login to continue.</p>
                    <hr>
                    <div style="float:right;">
                        <button class="button-primary" onclick="logout()">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>