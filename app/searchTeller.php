<?php


    include 'DAO/bankDao.php';
    $action = new bankDao();

    $searchTeller = $_POST["searchTellers"];

    $action->searchTeller($searchTeller);

?>