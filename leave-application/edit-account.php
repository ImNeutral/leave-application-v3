<?php
require_once ("Controllers/EditAccount.php");
?>


<?php include ('layouts/header.php'); ?>
<?php include ('layouts/top-navigation.php'); ?>

<section class="section main">
    <div class="row">

        <div class="twelve columns main-content">
            <?php include('layouts/absolute-nav.php'); ?>
            <h5 class="header">Edit Account</h5>
            <hr>
            <div class="container">
                <form action="" method="POST">
                    <table class="u-full-width">
                        <tr>
                            <td>Name:</td>
                            <td class="username"><?php echo $name;?></td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                Username:
                            </td>
                            <td class="username">
                                <?php echo $account['username']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Password:
                            </td>
                            <td>
                                <input type="password" name="password">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Confirm Password:
                            </td>
                            <td>
                                <input type="password" name="password2">
                            </td>
                        </tr>
                        <tr>
                            <td>Account Type:</td>
                            <td>
                                <select name="accountType">
                                    <?php for($roll = 1; $roll < count($accountType); $roll++) { ?>
                                        <option value="<?php echo $roll; ?>" <?php echo $roll == $account['account_type_id']? 'selected' : '';  ?> ><?php echo $accountType[$roll] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div class="six columns u-pull-right">
                        <a href="manage-accounts.php" class="button">BacK</a>
                        <input type="submit" value="Submit" class="button-primary">
                    </div>
                    <?php if(isset($message)){ ?>
                    <div class="seven columns u-pull-right">
                        <div class="error-message six columns <?php echo $messageStatus; ?>" id="error-message-search-name" style="margin-top: 0;">
                            <?php echo $message; ?>
                        </div>
                    </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>


</section>
<script>
    document.title = "Leave Application | Edit Account";
    $editAccount = document.getElementById('edit-account');
    $editAccount.className = 'active';
    $editAccount.style.display = 'unset';
</script>
<?php include ('layouts/footer.php');?>
