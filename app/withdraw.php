<?php

    include 'DAO/bankDao.php';

    $withdraw_amount = $_POST['withdraw_amount'];
    $userName = $_POST['userName'];

    $action = new bankDao();
    $action->withdraw($withdraw_amount, $userName);

?>