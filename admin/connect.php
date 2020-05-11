<?php

    $dsn = 'mysql:host=localhost;dbname=shop';
    $user = 'root';
    $password = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $con = new PDO($dsn,$user,$password,$option);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        // echo 'Welcome You Are Connected To Database';
    }
    catch(PDOException $e) {
        echo 'Failed To Connect Try Again ' . $e->getmessage();
    }