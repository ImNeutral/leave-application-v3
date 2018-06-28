<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>
<?php include('modals/previous-applications-modals.php'); ?>


<section class="hidden">
    <img id="hidden-image" src="" alt="" />
</section>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav-user.php'); ?>
            <h6 class="header">Previous Applications</h6>

            <hr>
            <div class="">
                <table class="u-full-width accounts" >
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="25%">Type</th>
                        <th width="10%">Days</th>
                        <th width="15%">Start</th>
                        <th width="10%">Status</th>
                    </tr>
                    </thead>
                    <tbody id="previous-applications-list">
                    </tbody>
                </table>

                <div class="pagination" id="pagination">
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    document.title      = "Leave Application | Previous Applications";
    document.getElementById('previous-applications').className = 'active';
    var modal           = document.getElementById('myModal');
//    var span            = document.getElementsByClassName("close")[0];
    var modalTitle      = document.getElementById("modal-title");

//    span.onclick = function() {
//        modal.style.display = "none";
//    };
//
//    modal.onclick = function(event) {
//        if (event.target == modal) {
//            modal.style.display = "none";
//        }
//    }
</script>

<script src="assets/js/previous-application.js"></script>
<script src="assets/js/edit-leave-application.js"></script>
<?php include ('layouts/footer.php');?>
