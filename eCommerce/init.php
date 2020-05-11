<?php

     // Error Reporting

     ini_set('display_errors', 'On');
     error_reporting(E_ALL);

     $sessionUser = '';
     if (isset($_SESSION['user'])) {
          $sessionUser = $_SESSION['user'];
     }
     include 'admin/connect.php';

    //  Routes

     $tep = 'Includs/templets/';    // tempelts Directory
     $css = 'layout/css/';          // css Directory
     $js = 'layout/js/';            // js Directory
     $lang = 'Includs/lang/';       // Language Directory
     $func = 'Includs/functions/';

     // Include The Important Files 

     include $lang . 'english.php';   //  Should be First 
     include $func . 'function.php';
     include $tep . 'header.php';

     