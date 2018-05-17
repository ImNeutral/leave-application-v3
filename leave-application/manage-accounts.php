<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav.php'); ?>
            <h5 class="header">Manage Accounts</h5>
            <hr>
            <div class="">
                <table class="u-full-width accounts">
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="25%">Full Name</th>
                        <th width="30%">Username</th>
                        <th width="20%">Module</th>
                        <th width="15%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href="" class="button button-primary button-sm">Edit</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</section>
<script>
    document.title = "Leave Application | Manage Accounts";
    document.getElementById('manage-accounts').className = 'active';
</script>
<?php include ('layouts/footer.php');?>
