<?php
include 'DAO/bankDao.php';
$action = new bankDao();
if (isset($_REQUEST["lastName"]) && isset($_REQUEST["firstName"]) && isset($_REQUEST["gender"]) && isset($_REQUEST["address"]) && isset($_REQUEST["contact"])&&  isset($_REQUEST["userName"]) && isset($_REQUEST["password"]) && isset($_REQUEST["confirm_password"]) && isset($_REQUEST["register_as"])){

   if($_REQUEST["password"] == "" ){
       $errPassword ="  error Password!";

   }else if($_REQUEST["register_as"] == "Customer"){
       if($_REQUEST["password"] != $_REQUEST["confirm_password"]){
           $errPassWord2 = "  Password Didn't Match!";
       }else{
           $verrify = $action->register($_REQUEST['lastName'], $_REQUEST['firstName'],  $_REQUEST['gender'], $_REQUEST['address'], $_REQUEST['contact'], $_REQUEST['userName'], $_REQUEST['password'], $_REQUEST['confirm_password'], $_REQUEST['register_as']);
           if($verrify){
               $errCheck = "Username already exist!";
               header('Location: login.php');
           }
       }
   }else{
       if($_REQUEST["confirm_password"] != "teller"){
           $errPassWord2 = "  Error confirmation!";
       }else{
           $verrify = $action->register($_REQUEST['lastName'], $_REQUEST['firstName'],  $_REQUEST['gender'], $_REQUEST['address'], $_REQUEST['contact'], $_REQUEST['userName'], $_REQUEST['password'], $_REQUEST['confirm_password'], $_REQUEST['register_as']);
           if($verrify){
               $errCheck = "Username already exist!";
               header('Location: login.php');
           }
       }
   }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Log In</title>

    <link rel = "stylesheet" type="text/css" href = "css/teller.css" />
    <link rel = "stylesheet" type="text/css" href = "bootstrap/css/bootstrap.css" />

    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/teller.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>

</head>

<body class="container">
<div id="quotation">
    <br/><h1><i>" A savings to a Million pesos starts with One peso. "</i> </h1>
</div><!--quotation-->

<form class="logIn" method="POST" action="login.php"><br/>
    Username:<input type="text" id="userName" name="userName" required>
    Password:<input type="password" name="password" required>
    Sign-in As <select name="as"><option>Customer</option><option>Teller</option><option>Admin</option></select>
    <button class="btn btn-small btn-primary" >Log-in</button><br />
    <p><?php if (isset($errMsg)) echo $errMsg; ?></p>
</form>

<div id="first">
    <img src="images/images1.jpeg" id="images" class="img-circle">
    <div id="aboutUs" >
        <div id="description">
            <h1>DESCRIPTION</h1>
            <p>Banking Tellering System allows the teller to keep the records of the customers such as customer's profile
                and customer's savings record. Tellers can add and view customer's profile but cannot be updated as well as the
                customer's savings account. The Admin can view all records of customers but can't update. Admin can add and view
                teller's information. All customers has its own records. They can view their records but no one can update it,
                only the profile/personal information will be updated by the customer itself.</p>
        </div>
        <div id="feature">
            <h1>FEATURES</h1>

            <h3>Teller</h3>
            <p>LOG IN and LOG OUT using his/her username and password.</p>
            <p>VIEW all Customer's Accounts (Name, Balance, Info, Savings).</p>
            <p>ADD CUSTOMER -> Allow tellers to add new customers.</p>
            <p>SEARCH customers via lastname.</p>
            <p>DEPOSIT and WITHDRAW money from/to the customer's savings account.</p>

            <h3>Admin</h3>
            <p>LOG IN  and LOG OUT using  username and password.</p>
            <p>VIEW Customer's Accounts (Name, Balance, Info, Savings).</p>
            <p>VIEW Teller's info.</p>
            <p>SEARCH customers and tellers via lastname.</p>

            <h3>Customers</h3>
            <p>LOG IN and LOG OUT using his/her username and password.</p>
            <p>VIEW his/her savings account.</p>
            <p>MY PROFILE -> view and update his/her profile account.</p>

        </div>
    </div>
    <div id="bank">
    </div>
    <form class="form" method="POST">
        <h1>Registration form</h1>
        Firstname : <input type="text" name="firstName" required><br>
        Lastname : <input type="text" name="lastName" required><br>
        Gender : <select id="gender" name="gender" required><option>Female</option><option>Male</option></select><br>
        Address : <input type="text" name="address" required><br>
        Contact # : <input type="text" name="contact" required><br>
        Username : <input type="text" name="userName" requiered><br>
        Password : <input type="password" name="password" required><p><?php if(isset($errPassWord)){echo $errPassWord;}?></p>
        Confirm Password : <input type="password" name="confirm_password" required><p><?php if(isset($errPassWord2)){echo $errPassWord2;}?></p>
        Register As : <select id="register_as" name="register_as" required><option>Teller</option><option>Customer</option></select><br /><br />
        <input type="hidden" name="customers_id"/>
        <button >Submit</button>
    </form>

</div>

</body>

</html>