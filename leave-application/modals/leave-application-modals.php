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

</section>