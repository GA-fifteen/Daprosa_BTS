<?php

    include 'DAO/bankDao.php';

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $position = "Teller";
    $status = "OFF";

    $action = new bankDao();
    $action->addTeller($firstName, $lastName, $gender, $address, $contact, $userName, $password, $confirm_password, $position, $status);

?>