<?php
    session_start();
    if (!isset($_SESSION['userName'])){
        header('Location: login.php');
    }
    else{
        $userName = $_SESSION['userName'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Bank Tellring System | <?php if (isset($userName)) echo $userName; ?></title>

    <script src = "js/jquery-1.8.2.min.js"></script>
    <script src = "js/jquery-ui-1.9.0.custom.min.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src = "js/teller.js"></script>

    <link rel = "stylesheet" type="text/css" href = "css/teller.css"/>
    <link rel = "stylesheet" type="text/css" href = "css/jquery-ui.css">
    <link rel = "stylesheet" type="text/css" href = "css/jquery-ui-1.10.1.custom.css"/>
    <link rel = "stylesheet" type="text/css" href = "css/jquery-ui-1.10.1.custom.min.css"/>
    <link rel = "stylesheet" type="text/css" href = "bootstrap/css/bootstrap.css" />

</head>
<body  class="container">

    <div id="first">
        <br/><h1><i>" A savings to a Million pesos starts with One peso. "</i> </h1>

        <ul id="menu">
            <li><a href="teller.php" >Customer's Account</a></li>
            <li><a id="logout">LOG OUT</a></li>
            <p id="name_teller">Teller</p>
        </ul>

        <div class="button">

            <h1>Customer's Records</h1>
            <button href="#addCustomer" role="botton" data-toggle="modal" >Add Customer</button>
            <button id="Deposit">Deposit</button>
            <button id="Withdraw">Withdraw</button>


            <div id="savings_tab">
    <!----------    DEPOSIT FORM HERE!      -------------->
                <div id="deposit">
                    <form class="form-horizontal">
                        <fieldset>
                            <legend><h1>Depositor Slip :</h1></legend>
                            Date : <?php date_default_timezone_set('Asia/Manila'); echo date('M-d-Y h:i:s a', time()); ?>
                            <div class="control-group">
                                <label class="control-label" for="deposit_amount">Deposit : </label>
                                <div class="controls">
                                    <input type="text" id="deposit_amount" name="deposit_amount" placeholder="Php    (amount in digit)" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="deposit_userName">Username : </label>
                                <div class="controlscontrolscontrolscontrols">
                                    <input type="text" id="_deposit_userName" name="deposit_userName" placeholder="Username" required>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div><!----  #deposit  ---->

    <!----------    WITHDRAW FORM HERE      -------------->
                <div id="withdraw">
                    <form class="form-horizontal">
                        <fieldset>
                            <legend><h1>Withdrawal Slip :</h1></legend>
                            Date : <?php date_default_timezone_set('Asia/Manila'); echo date('M-d-Y h:i:s a', time()); ?>
                            <div class="control-group">
                                <label class="control-label" for="withdraw_amount">Withdraw : </label>
                                <div class="controls">
                                    <input type="text" id="withdraw_amount" name="withdraw_amount" placeholder="Php     (amount in digit)" required>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="withdraw_userName">Username : </label>
                                <div class="controls">
                                    <input type="text" id="withdraw_userName" name="withdraw_userName" placeholder="Username" required>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div><!---- #withdraw   -->
                <span></span>

    <!----------    VIEW RECORDS(table)     ------------>
                <div id="tableRecord">
                    <input type="text" name="search" id="search" placeholder="search [input lastname]" required>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="table_header" colspan="3"><p>Customers</p></th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Savings Balance</th>
                            <th>options</th>
                        </tr>
                        </thead>
                        <div>
                            <tbody id="admin_customers"></tbody>
                        </div>
                    </table>

    <!----------    VIEW SAVINGS RECORDS(table dialog)      --------->
                    <div id="view_savingRecords" title="Savings Record">
                        <div id="tableScroll">
                            <table class="table table-hover">
                                <thead >
                                <tr>
                                    <th>date</th>
                                    <th>deposit</th>
                                    <th>withdraw</th>
                                    <th>balance</th>
                                </tr>
                                </thead>
                                <tbody id="view_savings">
                                </tbody>
                            </table>
                        </div>
                    </div>

    <!----------    VIEW CUSTOMERS INFO(dialog)     ---------------->
                    <div id="viewCusInfo">
                        <form class="view" id="viewInfo">
                            <div class="imageContainer">
                                <img alt=""  src="images/images1.jpeg" id="profileImage"><br />
                            </div>
                        </form>
                    </div>

                </div><!---  #tableRecords  --->
            </div><!---  #savings_tab  --->
        </div><!---  #button  --->

    <!----------    ADD CUSTOMER HERE       ---------------->
        <div id="addCustomer" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel">Register Customer</h3>
            </div>
            <div class="modal-body" >
                <form class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="firstName">Firstname : </label>
                        <div class="controls">
                            <input type="text" id="firstName" name="firstName" placeholder="Firstname" required="">
                         </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lastName">Lastname : </label>
                        <div class="controls">
                            <input type="text" id="lastName" name="lastName" placeholder="Lastname" required="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="gender">Gender : </label>
                        <div class="controls">
                            <select type="text" id="gender" name="gender"><option>Female</option><option>Male</option></select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address">Address : </label>
                        <div class="controls">
                            <input type="text" id="lastName" name="address" placeholder="Address" required="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="contact">Contact : </label>
                        <div class="controls">
                            <input type="text" id="contact" name="contact" placeholder="Contact" required="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="add_userName">Username : </label>
                        <div class="controls">
                            <input type="text" id="add_userName" name="add_userName" placeholder="Username" required="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Password : </label>
                        <div class="controls">
                            <input type="password" id="password" name="password" placeholder="Password" required="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="Confirm_password">Confirm Password : </label>
                        <div class="controls">
                            <input type="password" id="Confirm_password" name="confirm_password" placeholder="Confirm Password" required="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnAddCustomer" class="btn btn-primary">Add</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>

    </div><!--  #first -->

</body>

</html>