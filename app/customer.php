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

    <title>Bank Tellering System | <?php if (isset($userName)) echo $userName; ?></title>

    <script src = "js/jquery-1.8.2.min.js"></script>
    <script src = "js/jquery-ui-1.9.0.custom.min.js"></script>
    <script src = "bootstrap/js/bootstrap.js"></script>
    <script src = "js/customer.js"></script>

    <link rel = "stylesheet" type = "text/css" href = "css/customer.css"/>
    <link rel = "stylesheet" type = "text/css" href = "css/jquery-ui-1.10.1.custom.css"/>
    <link rel = "stylesheet" type = "text/css" href = "css/jquery-ui-1.10.1.custom.min.css"/>
    <link rel = "stylesheet" type = "text/css" href = "css/jquery-ui.css">
    <link rel = "stylesheet" type = "text/css" href = "bootstrap/css/bootstrap.css" />

</head>

<body class="container">

<div id="first">

    <br/><h1><i>" A savings to a Million pesos starts with One peso. "</i> </h1>
    <ul id="menu">
        <li><a href="customer.php">my account</a>
            <ul>
                <li><a href="customer.php">mySavingsAccount</a></li>
                <li><a id="Profile">myProfile</a></li>
            </ul>
        </li>
        <li><a href="logout.php">LOG OUT</a></li>
         <p id="name_customer"><strong>welcome</strong></p>
    </ul>

    <div id="savings">

        <div id="tableRecords">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="table_header" colspan="4"><p>mySavings Records</p></th>
                </tr>
                <tr>
                    <th>date </th>
                    <th>deposit</th>
                    <th>withdraw </th>
                    <th>balance </th>
                </tr>
                </thead>
                <tbody id="records">
                </tbody>
            </table>
        </div><!--tableRecords-->
    </div>


    <div id="myProfile">

        <!--VIEW CUSTOMERS-->
        <form id="viewProfile" border="1">
            <div class="imageContainer">
                <img alt=""  src="images/images1.jpeg" id="profileImage"><br />
            </div>
            <!--	<form name="form" action="" method="post" enctype="multipart/form-data">
                Photo: <input type="file" name="file" />
                <input type="submit" name="submit" value="submit" />
                </form>-->
        </form>
        <!-- END OF VIEW CUSTOMERS-->

        <!--EDIT CUSTOMER'S INFO FORM-->
        <div id="editing" title="Editing Customer's Info">

            <form class="form-horizontal">
                <fieldset id="edited">
                    <div class="control-group">
                        <label class="control-label" for="firstName" >Firstname</label>
                        <div class="controls">
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lastName" >Lastname</label>
                        <div class="controls">
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="gender" >Gender</label>
                        <div class="controls">
                            <select id="gender" name="gender"><option>Female</option><option>Male</option></select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="address" >Address</label>
                        <div class="controls">
                            <input type="text" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="contact" >Contact</label>
                        <div class="controls">
                            <input type="text" id="contact" name="contact" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="userName" >Username</label>
                        <div class="controls">
                            <input type="text" id="userName" name="userName" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password" >Password</label>
                        <div class="controls">
                            <input type="text" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="confirm_password" >Confirm Password</label>
                        <div class="controls">
                            <input type="text" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    <input type="hidden" name="users_id"/>
                </fieldset>
            </form>
        </div><!--editing-->
        <!--END OF EDIT CUSTOMER'S INFO FORM-->
    </div>


</div><!--first-->



</body>

</html>