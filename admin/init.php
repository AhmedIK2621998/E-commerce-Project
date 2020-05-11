<?php

     include 'connect.php';

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

     //  Include Navbar On All Pages Expect The One With $noNavbar Variable
     // $noNavbar بمعني انه يعمل شريط الناف بار في كل الصفحات ماعدا صغحه اللي تحتوي علي المتغير 
     if (!isset($noNavbar)) {   include $tep . 'Navbar.php'; }
     