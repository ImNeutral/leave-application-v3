<?php
require_once ("Controllers/CreateAccount.php");
?>


<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav.php'); ?>
            <h5 class="header">Create Account</h5>
            <hr>
            <div class="">
                <?php if(isset($_GET['first_name']) && isset($_GET['last_name'])  && isset($employee->id)) { ?>

                <form action="" method="POST">
                    <table class="u-full-width">
                        <tr>
                            <td>Name:</td>
                            <td class="username"><?php echo ucwords(strtolower($employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name)); ?></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Username:
                            </td>
                            <td>
                                <input type="text" name="username" value="<?php echo $username ?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Password:
                            </td>
                            <td>
                                <input type="password" name="password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Confirm Password:
                            </td>
                            <td>
                                <input type="password" name="password2" required>
                            </td>
                        </tr>
                        <tr>
                            <td>Account Type:</td>
                            <td>
                                <select name="accountType" required>
                                    <?php for($roll = 1; $roll < count($accountType); $roll++) { ?>
                                        <option value="<?php echo $roll; ?>" <?php echo $accountTypeOld==$roll? ' selected ' : ''; ?>><?php echo $accountType[$roll] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="six columns u-pull-right">
                        <a href="?" class="button">Back</a>
                        <input type="submit" value="Submit" class="button-primary">
                    </div>
                    <?php if( isset($_POST['username']) && isset($_POST['password'])  && isset($_POST['accountType']) && !isset($account->id) && isset($employee->id) ) { ?>
                    <div class="seven columns u-pull-right">
                        <div class="error-message five columns <?php echo $messageStatus; ?>" id="error-message-search-name" style="margin-top: 0;">
                            <?php echo $message; ?>
                        </div>
                    </div>
                    <?php } ?>
                </form>
                <?php } else { ?>
                    <form action="" id="search-name-form">
                        <table class="u-full-width">
                            <tr>
                                <td width="40%">First Name:</td>
                                <td class="">
                                    <input type="text" name="first_name" value="<?php echo $firstName ?>" required>
                                </td>
                            </tr>
                            <tr>
                                <td width="40%">Last Name:</td>
                                <td class="">
                                    <input type="text" name="last_name" value="<?php echo $lastName ?>" required>
                                </td>
                            </tr>
                        </table>

                        <div class="six columns u-pull-right">
                            <button type="submit" class="button-primary" id="search-submit">Next</button>
                        </div>
                    </form>
                    <?php if( isset($_GET['first_name']) && isset($_GET['last_name']) && !isset($employee->id) ) { ?>
                    <div class="eight columns u-pull-right">
                        <div class="error-message five columns danger" id="error-message-search-name" style="margin-top: 0;">
                            <?php echo $message; ?>
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>


</section>
<script>
    document.title = "Leave Application | Create Account";
    document.getElementById('create-account').className = 'active';
</script>


<?php include ('layouts/footer.php');?>
