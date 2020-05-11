<?php

/*
    That's The Importants Page In This Project Why ? Becouse The Project Will Contain Many Function 
    sush Categories => [ Manage | Edit | Update | Add | Delete | Insert | Statistic ]  And Every Page Frome This
    Will Contain Many Function 
    So Not Create Any Page From This لوحدها so  I Make The GET action to get The Modify from The Get 

   if(condtion) {} == conditon ? true:false;
*/
     // $action = isset($_GET['action'])? $_GET['action']: 'Mange';
    // Another Condtion
     $action = '';

    if( isset($_GET['action'])) {

        $action =  $_GET['action'];

    } else {

        $action = 'Manage';
    }
    // echo $action;

    // If The Page Is Main Page

    if ( $action == 'Manage') {

        echo 'Welcome You Are In Manage Categorey Page';
        echo '<a href="?action=Insert">Add New Categorey+</a>';
      // or   echo '<a href="page.php?action=Add">Add New Categorey+</a>';

    } elseif ( $action == 'Insert') {

        echo 'Welcome You Are In Insert Categorey Page';

    } elseif ( $action == 'Add') {

        echo 'Welcome You Are In Add Categorey Page';

    } elseif ( $action == 'Update') {

        echo 'Welcome You Are In Update Categorey Page';

    } else {

        echo 'Error Ther\'s No Page Here';
    }