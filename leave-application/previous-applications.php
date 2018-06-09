<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav-user.php'); ?>
            <h5 class="header">Previous Applications</h5>

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
<!--                    loop for each leave application-->
<!--                        <tr class="dataTR">-->
<!--                            <td>1</td>-->
<!--                            <td>Sick Leave</td>-->
<!--                            <td>3</td>-->
<!--                            <td>April 12, 2019</td>-->
<!--                            <td class="primary-font">Rejected</td>-->
<!--                        </tr>-->
                    </tbody>
                </table>

            </div>
        </div>
    </div>


</section>

<section class="modal-section">
    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <h6 id="modal-title" class="text-center">Sick Leave - 6 days</h6>
            <table>
                <tr>
                    <td>Test</td>
                    <td>Test2</td>
                </tr>
                <tr>
                    <td>TTest</td>
                    <td>TTest2</td>
                </tr>
            </table>
<!--            <p class="float-left"><b>No. of days:&nbsp;</b></p> <p id="modal-item-days">6 Days</p>-->
<!--            <p class="float-left"><b>Date Start:&nbsp;</b></p> <p id="modal-item-date-start">Jun 15, 2018</p>-->
<!--            <p class="float-left"><b>Currently in:&nbsp;</b></p> <p id="modal-item-date-start">SDS</p>-->
            <hr>
            <div style="text-align: center;">
                <button class="button-primary">View Details</button>
                <button class="button-danger">Cancel Application</button>
            </div>
        </div>

    </div>

</section>

<script>
    document.title      = "Leave Application | Previous Applications";
    document.getElementById('previous-applications').className = 'active';
    var modal           = document.getElementById('myModal');
    var span            = document.getElementsByClassName("close")[0];
    var modalTitle      = document.getElementById("modal-title");

    span.onclick = function() {
        modal.style.display = "none";
    };

    modal.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


</script>

<script src="assets/js/previous-application.js"></script>
<?php include ('layouts/footer.php');?>
