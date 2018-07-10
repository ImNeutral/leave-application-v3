<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">
        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav.php'); ?>
            <h6 class="header">Application Reports</h6>
            <hr>
            <div class="twelve columns">
                <div class="six columns">

                    <select name="" id="year" class="select-sm">
                        <?php for ($roll = 2018; $roll <= date('Y')+1 ; $roll++) { ?>
                            <option value="<?php echo $roll; ?>" <?php echo $roll == date('Y')? 'selected' : ''; ?>><?php echo $roll; ?></option>
                        <?php } ?>
                    </select>
                    <?php
                    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                    ?>
                    <select name="" id="month" class="select-sm">
                        <option value="0" selected disabled>-Month-</option>
                        <?php for ($roll = 1; $roll <= count($months); $roll++) { ?>
                            <option value="<?php echo $roll; ?>"><?php echo $months[$roll-1]; ?></option>
                        <?php } ?>
                    </select>
                    <select name="" id="day" class="select-sm">
                        <option value="" selected disabled>-Day-</option>
                    </select>

                </div>
                <div class="six columns">
                    <div class="float-right">
                        <button class="button-primary button-sm small-radius" id="print-go" style="display: none;">Print</button>
                    </div>
                </div>

                <div class="float-right info-font">
                    <p id="search-message">Showing results for "search".</p>
                </div>
            </div>
            <br><br>
            <div class="">
                <table class="u-full-width" id="applications">
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="35%">Applicant</th>
                        <th width="25%">Type</th>
                        <th width="10%">Days</th>
                        <th width="20%">Start</th>
                    </tr>
                    </thead>
                    <tbody id="applications-list">
                    <tr>
                        <td colspan="5" class="text-center">Please select a month.</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination" id="pagination">
            </div>
        </div>
    </div>
</section>

<datalist id="schools">
</datalist>

<datalist id="employees">
</datalist>

<script>
    document.title = "Application Reports";
    document.getElementById('application-reports').className = 'active';
</script>

<script src="assets/js/application-reports.js"></script>
<?php include ('layouts/footer.php');?>
