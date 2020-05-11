<?php

    /*
    ** Get All Function v2.0
    ** Function To Get All Recordes From Any Database Table
    **/

    function getAllFrom($field, $table, $where = NULL,$and = NULL, $orderfield , $ordering = "DESC") {

        global $con;

        // $sql = $where == NULL? '' : $where;    

        $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

        $getAll->execute();

        $all = $getAll->fetchAll();

        return $all;
    }

    /*
    ** check If User Is Not Activated
    ** Function To check The RegStatus Of The Usre
    **/

    function checkUserStatus($user) {

        global $con;
        
        $stmtx = $con->prepare("SELECT
                                     UserID,RegStatus 
                                FROM 
                                     users 
                                WHERE 
                                     UserName = ?
                                AND 
                                    RegStatus = 0");  
        
        
        $stmtx->execute(array($user));

        $status = $stmtx->rowCount();

        return $status;
    }
















    /**
    ** Title Function That Echo The Title page In Case Any Page
    ** Using The Vriable $pageTitle And Echo Default For Any Other Page
    */

    function gettitle() {

        global $pageTitle;
        
        if (isset($pageTitle)) {

            echo $pageTitle;

        } else {

            echo 'Default';
            
        }
    }

    /*   Function v2.0
     *** Home Redirect [ This Function Accept Argument From Me]
     *** 1 ==> $theMes = Echo  The Message  [ Error | Success | Warning ]
     *** 2 ==> $url = The Link You Want Redirect To   المكان اللي عايز تروحه
     *** 2 ==> $Seconds = Seconds Befor Redirct 
     */
      
     // التحديث الجدبد اني اخلي الداله من نفسه توديني علي المكان اللي انا عايزه

     function redirctHome($theMes, $url = null , $Seconds = 3 ) {

        if ( $url === null) {

            $url  = 'index.php';

            $link = 'HomePage';
        }
        else {
            
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

                $url = $_SERVER['HTTP_REFERER'];

                $link = 'Previous Page';

            } else {
                
                $url = 'index.php';

                $link = 'HomePage';

            }
            

        }

        echo   $theMes ;
        echo "<div class='alert alert-info'> You Will Redirct To $link After $Seconds seconds. <div>";

        header("refresh:$Seconds;url=$url");

        exit();

     }

     /*     Create Check Item Function    شرح للداله اللي هعملها
     **
     **  check Item Function v1.0
     **  Function To Check Item In Data Base [ Function Accept Parameters]
     **  $select = The Item To select [ Example: users, Item, Categorie]    زي مثلا العناصر اللي في الجدول اللي هسحب منها
     **  $from   = The Table To Select From [Example: users, Item, Categorie]  زي اسم المكان او الجدول الي هسحب منه
     **  $value  = The Value Of Select  [Example: Ahmed, Box, Electronic]   القيمه اللي المفروض تيحيلي سواء وبعبر عنها  ؟
     **
      */

        //   شرح الليله دي كلها ان الداله بتعمل فحص علي الاستعلام هل موجود في الداتا بيز والا مش موجود
      
        function CheckItem($select ,$from , $value) {

        global $con ;     // علشان يتشاف في اي مكان

        $statmenet = $con->prepare("SELECT $select FROM $from WHERE $select=?");     //  ? || $value

        $statmenet->execute(array($value));

        $count = $statmenet->rowCount();

        return $count;
      }

      /*
       ** Count Number Of Items v1.0
       ** Function To Count Number Of Items Row
       ** $item = The Item That I wante To Count  Or The Item To Count
       ** $table = The To Choose From  
       ** 
       */

    function countItems( $item , $table ) {

    global $con;

    $stmt1 =$con->prepare("SELECT COUNT($item) FROM $table");

    $stmt1->execute();

    return $stmt1->fetchColumn();
  
    }

    /*
    ** Get Latest Records Function v1.0
    ** Function To GetLatest Item From Database [Users, Items, Comments]
    ** $select =  The Field To Select
    ** $table = The Table To Choose From It
    ** $order = The Desc Ordering 
    ** $limit = The Limit Of Variable To Show It
    ** 
     */

     function getLatest ( $select , $table , $order ,$limit = 5) {

        global $con;

        $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");

        $getstmt->execute();

        $row = $getstmt->fetchAll();

        return $row;
     }