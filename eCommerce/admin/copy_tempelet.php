<?php

    /*
    =========================================================
    === This Page It To Mange Members Page
    === You Can Edit | Add | Delete Member From Here
    =========================================================
    */
    
     ob_start();

     session_start();

     $pageTitle= 'Members';

     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا

        include 'init.php';
        
        $action = isset($_GET['action']) ? $_GET['action']: 'Manage';    // IF CONDITION

        if ($action == 'Manage') { // Start  Manage Page 
            
            echo 'Welcome';

        } elseif ($action == 'Add') {

        } elseif ($action == 'Insert') {

        } elseif ($action == 'Edit') {

        } elseif ($action == 'Update') {
            
        } elseif ($action == 'Delete') {
            
        } elseif ($action == 'Activate') {
            
        }
         
        include $tep . 'footer.php'; 

    } else {

       header('Location: index.php');
       exit();
       
    }

    ob_end_flush();

?>