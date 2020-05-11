<?php

    /*
    =========================================================
    === This Page It To Mange Comment Page
    === You Can Add | Delete Comment From Here
    =========================================================
    */

    ob_start();  //  Output Buffering Start

    session_start();

     $pageTitle= 'Comments';

     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا

        include 'init.php';

        $action = isset($_GET['action']) ? $_GET['action']: 'Manage';    // IF CONDITION

        //  Start Manange Page

        if ($action == 'Manage') { // Start  Manage Page 
            
            // Select All User Except Admin  
            $stmt = $con->prepare("SELECT 
                                        comments.*,items.Name AS Item_Name,users.UserName AS Member
                                    FROM 
                                        comments
                                    INNER JOIN
                                        items
                                    ON
                                        items.Item_ID = comments.item_id
                                    INNER JOIN
                                        users
                                    ON
                                        users.UserId = comments.user_id
                                    ORDER BY 
                                        c_id 
                                    DESC");

            // Execute The Statment
            $stmt->execute();

            // Assign To Variable
            $comments = $stmt->fetchAll();
            if(! empty($comments)) {
                ?>
               <h1 class="text-center">Manage Comments</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>ID</td>
                                <td>Comment</td>
                                <td>Item Name</td>
                                <td>User Name</td>
                                <td>Added Date</td>
                                <td>#Control</td>
                            </tr>

                            <?php 

                                foreach ($comments as $comment) {

                                    echo '<tr>';
                                        echo "<td>" . $comment['c_id'] . "</td>";
                                        echo "<td>" . $comment['comment'] . "</td>";
                                        echo "<td>" . $comment['Item_Name'] . "</td>";
                                        echo "<td>" . $comment['Member'] . "</td>";
                                        echo "<td>" . $comment['comment_date'] . "</td>";
                                        echo "<td>
                                            <a href='comments.php?action=Edit&comid=" . $comment['c_id'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                            <a href='comments.php?action=Delete&comid=" . $comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

                                            if ($comment['status'] == 0) {
                                                    echo "<a 
                                                            href='comments.php?action=Approve&comid=" . $comment['c_id'] . "' 
                                                            class='btn btn-info activate'>
                                                            <i class='fa fa-check'></i> Approve </a>";
                                            
                                            }
                                        echo "</td>";
                                    echo '</tr>';

                                }
                            // ?>
                        </table>
                    </div>
                </div>
            <?php } else {
                    echo '<div class="container">';
                        echo '<div class="nice-message">There\'s No Comments To Show</div>';
                }
            ?>
       <?php  
        
        } elseif( $action == 'Edit') {// Edit Comment Page
            
            //  Check If comid numeric & get integer value

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0 ; 
            
             // Selecet All Data depond On userid

            $stmt = $con->prepare(" SELECT 
                                        * 
                                    FROM 
                                        comments 
                                    WHERE 
                                        c_id = ?");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
           
            // Execute The Query

            $stmt->execute(array($comid));
            
            // Fetch The Data

            $row = $stmt->fetch();

            // Row Count

            $count = $stmt->rowCount();

            // If The Ther's userid Show This Form

            if ( $count > 0) { ?>

                        <h1 class="text-center">Edit Comment</h1>
                        <div class="container">
                        <form class="form-horizontal" action="?action=Update" method="POST">
                            <input type="hidden" name="comid" value="<?php echo $comid; ?>">
                        <!-- Start Comment Field To Edit -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Comment</label>
                                <div class="col-sm-10 col-md-8">
                                   <textarea class="form-control" name="comment"><?php echo $row['comment']?></textarea>
                                </div>
                        </div>
                        <!-- End Comment Field -->
                        <!-- Start Submit button -->
                        <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input type="submit" value="Save" class="btn btn-primary btn-lg">
                                </div>
                        </div>
                        <!-- End submit Field -->
                        </form>
                    </div>
            <?php 
               } 
               // If Ther's No Such userid Show Error Message
               else {

                    echo '<div class="container">';

                    $theMes = '<div class="alert alert-danger">Ther Is No Such Id</div>';

                    redirctHome($theMes);
                      
                    echo '</div>';
                 }
             } elseif ( $action == 'Update') {

                    // Update The Userinfo 

                    echo "<h1 class='text-center'>Update Members</h1>";
                    echo "<div class='container'>";
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                        // Get The Data From The Form

                        $comid      = $_POST['comid'];
                        $comment    = $_POST['comment'];

                        // Make Update For This Value In Datbase

                        $stmt = $con->prepare(" UPDATE 
                                                    comments 
                                                SET 
                                                    comment=? 
                                                WHERE 
                                                    c_id=?");

                        $stmt->execute(array($comment, $comid));

                        // Echo Success Message 

                        $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
                    
                        redirctHome($theMes, 'back');
                    
                    } else {

                        $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                        redirctHome($theMes);
                        
                    }

                   echo  "</div>";

            } elseif ($action == 'Delete') {   // Delete The Comment From Page


                    echo "<h1 class='text-center'>Delete Comment</h1>";
                    echo "<div class='container'>";

                    //  Check If comid numeric & get integer value

                    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0 ; 
                            
                    // Selecet All Data depond On userid

                    
                    $check = CheckItem('c_id' ,'comments' , $comid);

                    // Execute The Query

                    if ( $check  > 0) {
                        
                        // Make Delete From DataBase

                        // $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
                        $stmt = $con->prepare(" DELETE 
                                                FROM 
                                                    comments 
                                                WHERE 
                                                    c_id = :zid");    //Another Way bindparam

                        $stmt->bindparam(":zid", $comid);    // Another Way   الربط بين المتغير والقميه اللي جايه 

                        // Execute The Query

                        $stmt->execute();

                        $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted </div>';
                        
                        redirctHome($theMes,'back');

                    } else {

                        $theMes = '<div class="alert alert-success">The ID Not Exists</div>';

                        redirctHome($theMes);

                    }
                    echo '</div>';

             } elseif ($action == 'Approve') {

                        echo "<h1 class='text-center'>Approve Comment</h1>";
                        echo "<div class='container'>";

                        //  Check If uerid numeric & get integer value

                        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']): 0 ; 
                                
                        // Selecet All Data depond On userid
                        
                        $check = CheckItem('c_id' ,'comments' , $comid);


                        if ( $check  > 0) {
                            
                            // Make Activate To DataBase

                            $stmt = $con->prepare("UPDATE 
                                                        comments 
                                                    SET 
                                                        `status` = 1 
                                                    WHERE 
                                                        c_id=?");    //Another Way bindparam
                            
                            // Execute The Query
                            $stmt->execute(array($comid));

                            $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved </div>';
                            
                            redirctHome($theMes,'back');

                        } else {

                            $theMes = 'The ID Not Exists';

                            redirctHome($theMes);

                        }
                        echo '</div>';            
                     }

        include $tep . 'footer.php'; 

    } else {

        header('Location: index.php');
        exit();
        
    }
     ob_end_flush();