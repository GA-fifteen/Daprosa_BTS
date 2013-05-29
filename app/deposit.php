<?php

    include 'DAO/bankDao.php';


    $deposit_amount = $_POST['deposit_amount'];
    $userName = $_POST['userName'];

    $action = new bankDao();
    $action->deposit($deposit_amount, $userName);

?>