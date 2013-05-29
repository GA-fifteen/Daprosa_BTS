<?php
    session_start();
    include 'DAO/bankDao.php';
    $userName = $_SESSION['userName'];

    $action = new bankDao();
    $action->viewName($userName);
?>