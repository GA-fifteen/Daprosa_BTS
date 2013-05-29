<?php
    session_start();
    include 'DAO/bankDao.php';


    if (isset($_SESSION['userName'])){
        $userName = $_SESSION['userName'];

        $action = new bankDao();
        $action->logOut($userName);
        session_unset();
        session_destroy();
        header('Location: index.php');
    }

?>