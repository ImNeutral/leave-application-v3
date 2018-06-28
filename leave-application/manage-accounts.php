<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">
        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav.php'); ?>
            <h6 class="header">Manage Accounts</h6>
            <hr>
            <div class="twelve columns">
                <div class="six columns">
                    <button class="button-primary button-sm small-radius" id="create-account">+ Create Account</button>
                </div>
                <div class="six columns">
                    <div class="float-right">
                        <select name="" id="search-by" class="select-sm">
                            <option value="school">By School</option>
                            <option value="username">By Username</option>
                        </select>
                        <input type="text" class="input-sm" placeholder="Search By School" id="search" list="schools">
                        <button class="button-primary button-sm small-radius">Search</button>
                    </div>
                </div>

                <div class="float-right info-font" style="display: none;">
                    <p>Showing results for "search".</p>
                </div>
            </div>
            <br><br>
<!--            <div class="twelve columns">-->
<!--                <input type="text" class="input-sm" list="schools" id="search-school" placeholder="Search By School">-->
<!--                <button class="button-info button-sm small-radius">Users</button>-->
<!--                <button class="button-info button-sm small-radius">Principal</button>-->
<!--                <button class="button-info button-sm small-radius">Human Resource</button>-->
<!--                <button class="button-info button-sm small-radius">Division Superintendent</button>-->
<!--                <button class="button-info button-sm small-radius">Admin</button>-->
<!--            </div>-->
            <div class="">
                <table class="u-full-width accounts">
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="30%">Username</th>
                        <th width="20%">Module</th>
                        <th width="25%">Owner</th>
                    </tr>
                    </thead>
                    <tbody id="accounts-list">
                    <tr>
                        <td>1</td>
                        <td>Christian Garillo</td>
                        <td>chgar</td>
                        <td>User</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<datalist id="schools">
</datalist>
<script>
    document.title = "Manage Accounts";
    document.getElementById('manage-accounts').className = 'active';
</script>

<script src="assets/js/manage-accounts.js"></script>
<?php include ('layouts/footer.php');?>
