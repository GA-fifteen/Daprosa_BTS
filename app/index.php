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

    <title>Bank Tellering System</title>

    <script src = "js/jquery-1.8.2.min.js"></script>
    <script src = "js/jquery-ui-1.9.0.custom.min.js"></script>
    <script src = "bootstrap/js/bootstrap.js"></script>
    <script src = "js/index.js"></script>

    <link rel = "stylesheet" type = "text/css" href = "css/index.css"/>
    <link rel = "stylesheet" type = "text/css" href = "css/jquery-ui-1.10.1.custom.css"/>
    <link rel = "stylesheet" type = "text/css" href = "css/jquery-ui-1.10.1.custom.min.css"/>
    <link rel = "stylesheet" type = "text/css" href = "css/jquery-ui.css">
    <link rel = "stylesheet" type = "text/css" href = "bootstrap/css/bootstrap.css" />

</head>

<body class="container">

<div id="first">

    <br/><h1><i>" A savings to a Million pesos starts with One peso. "</i> </h1>

    <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1" class="menuStyle" data-toggle="tab">Customers</a></li>
            <li><a href="#tab2" class="menuStyle" data-toggle="tab">Tellers</a></li>
            <li><a href="logout.php" class="menuStyle">LOG OUT</a></li>
        </ul>
        <div class="tab-content">
<!------------------    CUSTOMERS   ------------------------>
            <div class="tab-pane active" id="tab1">
                <h1>Customer's Records</h1>
                <div id="records">
                    <input type="text" name="" id="search" placeholder="search [input lastname]" required>
                    <table class="table table-hover">
                        <thead>
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
                    <div id="viewCusInfo">
                        <form class="view" id="viewInfo">
                            <div class="imageContainer">
                                <img alt=""  src="images/images1.jpeg" id="profileImage"><br />
                            </div>
                        </form>
                    </div><!--#viewCusInfo-->
                </div><!--records-->
            </div><!-- #tab1-->

<!------------------    TELLER  ------------------------------------->
            <div class="tab-pane" id="tab2">
                <h1>Teller's Records</h1>
                <button href="#addCustomer" role="botton" data-toggle="modal" >Add Teller</button><br>
                <div id="records">
                    <input type="text" name="searchTellers" id="searchTellers" placeholder="search [input lastname]" required>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Username</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <div>
                            <tbody id="view_tellers"></tbody>
                        </div>
                    </table>
                    <!----------    ADD Teller HERE       ---------------->
                    <div id="addCustomer" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                            <h3 id="myModalLabel">Register Teller</h3>
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
                                        <select type="text" id="gender" name="gender" placeholder="Gender"><option>Female</option><option>Male</option></select>
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
                                        <input type="password" id="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="confirm_password">Confirm Password : </label>
                                    <div class="controls">
                                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm password" required="">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="btnAddTeller" class="btn btn-primary">Add</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                        </div>
                    </div><!--#addCustomer-->

                </div><!--#records-->
            </div><!--#tab2-->
        </div><!-- .tab-content-->

    </div><!--.tabbable-->

</div><!--first-->



</body>

</html>