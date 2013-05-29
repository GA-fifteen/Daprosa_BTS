<?php
include 'DAO/bankDao.php';

$action = new bankDao();

$id = $_POST['id'];

$action->editCustomer($id);

?>