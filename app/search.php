<?php


include 'DAO/bankDao.php';
$action = new bankDao();

$search = $_POST["search"];

$action->search($search);

?>