<?php

include 'DAO/bankDao.php';

$id = $_POST['users_id'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$userName = $_POST['userName'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$action = new bankDao();

$action->saveCustomers($id, $firstName, $lastName, $gender, $address, $contact, $userName, $password, $confirm_password);

?>