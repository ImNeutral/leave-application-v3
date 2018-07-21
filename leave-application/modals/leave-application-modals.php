<section class="modal-section">
    <div id="confirmModal" class="modal">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center modal-title" id="cc-operation">Successfully Submitted Application!</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <a href="previous-applications.php" id="cc-cancel" class="button button-primary">View Previous Applications</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmSubmitModal" class="modal">
        <div class="modal-content" style="margin-top: 10%; height: 150px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center modal-title" id="cc-operation">The form will now be submitted..</h5>

            <div class="modal-inside">
                <div style="text-align: center;">
                    <hr>
                    <div style="float:right;">
                        <button id="confirmSubmit_Ok" class="button-primary">Submit</button>
                        <button id="confirmSubmit_Cancel" class="button-danger" onclick="closeModal(this)">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="now-offline" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 180px;">
                <span class="close" id="close-cc"></span>
                <h5 class="text-center info-modal-title" id="info-modal-title">No Internet Connection!</h5>
                <div class="modal-inside" style="back">
                    <div style="text-align: center;">
                        <p>Please connect to the internet to submit leave application.</p>
                        <hr>
                    </div>
                </div>
        </div>
    </div>

    <div id="connection-back" class="modal" style="display: none;">
        <div class="modal-content" style="margin-top: 10%; height: 180px;">
            <span class="close" id="close-cc"></span>
            <h5 class="text-center info-modal-title" id="info-modal-title">Connection is back!</h5>
            <div class="modal-inside" style="back">
                <div style="text-align: center;">
                    <p>Submitting leave application, Please wait</p>
                    <p id="connection-back-label">* * * * *</p>
                    <hr>
                </div>
            </div>
        </div>
    </div>

</section>