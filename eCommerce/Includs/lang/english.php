<?php

    function lang ( $phrase )  {

        static $lang = array(
            
            'Home'              => 'Home',
            'CATEGORIES'        => 'Categories',
            'ITEMS'             => 'Items',
            'MEMBERS'           => 'Members',
            'COMMENTS'          => 'Comments',
            'STATISTICS'        => 'Statistics',
            'LOGS'              => 'logs'
        );

        return $lang[$phrase];
    }

    // $lang = array(
    //     'Ahmed' => 'Ibrahim'
    // );

    // echo $lang['Ahmed'];