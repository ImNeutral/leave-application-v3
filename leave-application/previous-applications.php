<?php
require_once ("Controllers/PreviousApplicationsController.php");
?>


<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav-user.php'); ?>
            <h5 class="header">Previous Applications</h5>

            <hr>
            <div class="">
                <table class="u-full-width accounts">
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="25%">Type</th>
                        <th width="10%">Days</th>
                        <th width="15%">Start</th>
                        <th width="10%">Processing</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($leaveApplications as $leaveApplication) { ?>
                        <tr class="dataTR">
                            <td><?php echo ++$tableNumber; ?></td>
                            <td><?php echo ucfirst($leaveApplication->type_of_leave); ?></td>
                            <td><?php echo $leaveApplication->number_days_applied; ?></td>
                            <td><?php echo $leaveApplication->getFormattedDate(); ?></td>
                            <td>HRO</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php if($page > 1) {?>
                        <a href="<?php echo '?page=' . ($page - 1); ?>" class="button button-primary button-sm"> << </a>
                    <?php } ?>
                    <?php for($roll=1; $roll <= $pagesCount; $roll++){ ?>
                        <a href="<?php echo "?page=" . $roll; ?>" class="button button-primary button-sm <?php echo $page==$roll? 'active' : ''; ?>"> <?php echo $roll; ?> </a>
                    <?php } ?>

                    <?php if($page < $pagesCount) { ?>
                        <a href="<?php echo '?page=' . ($page + 1); ?>" class="button button-primary button-sm"> >> </a>
                    <?php } ?>
                </div>
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
    $tr                 = document.querySelectorAll("tr.dataTR");
    $tr.forEach(function ($eachTr) {
        $eachTr.addEventListener("click", function (e) {
            var element = this;
            console.log(element.children[1].textContent);
            modalTitle.textContent = element.children[1].textContent + " Leave";
            modal.style.display = "block";
        });
    });


    span.onclick = function() {
        modal.style.display = "none";
    };

    modal.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


</script>
<?php include ('layouts/footer.php');?>
