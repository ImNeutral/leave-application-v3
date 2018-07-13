<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>
<?php include('modals/admin-modals.php'); ?>

<section class="hidden">
    <img id="hidden-image" src="" alt="" />
</section>

<section class="section main">
    <div class="row">
        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav-admin.php'); ?>
            <h6 class="header" id="header">New Applications</h6>

            <hr>
            <div class="">
                <table class="u-full-width accounts" >
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="30%">Type</th>
                        <th width="10%">Days</th>
                        <th width="20%">Start</th>
                    </tr>
                    </thead>
                    <tbody id="applications-list">
                    </tbody>
                </table>

                <div class="pagination" id="pagination">
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    document.title      = "Leave Application Actions";
    $id('new-applications').classList.add('active');

</script>
<script src="assets/js/admin-actions.js"></script>
<?php include ('layouts/footer.php');?>
