<?php

    session_start();
    include 'DAO/bankDao.php';
    $action = new bankDao();

    $userName = $_SESSION["userName"];

    $action->viewSavings($userName);


?>