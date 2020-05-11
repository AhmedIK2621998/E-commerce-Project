<?php

    session_start();

    session_unset();   // to unset the session

    session_destroy();  // to destory session

    header('Location: index.php');

    exit();