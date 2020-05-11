<?php

     ob_start();          /* Output Buffering Start ==
                                 يطبع كل المخرجات اللي في الصفحه ويخزنها في الميموري 
                                 الي ان بصل الي اخر الصفحه ثم بيعرض كل حاجه في الصفحه     
                                 */

     session_start();

     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا

        $pageTitle= 'Dashboard';

        include 'init.php';
        
        // The Initition Variable To Limit

        $numUsers = 6;   // Number Of Latest User
         
        // The function To GetLatest Any Theing

        $latestUsers = getLatest ("*","users","UserID",$numUsers);  // Latest User Array

        $numItems = 6;   // Number Of Latest Items

        $latestItems = getLatest ("*","items","Item_ID",$numItems);  // Latest Item Array

        $numComments = 4;   // Number Of Latest Comments


      ?>
         <!--  Start The Dashboard Page  -->

         <div class='home-stats'>
            <div class="container home-stats text-center">
               <h1>Dashboard</h1>
                  <div class="row">
                     <div class="col-md-3">
                        <div class="stat st-members">
                           <i class="fa fa-users"></i>
                           <div class="info">
                              Total Memebers
                              <span>
                                 <a href="members.php"><?php echo countItems( 'UserID' , 'users' ) ?></a>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="stat st-pending">
                           <i class="fa fa-user-plus"></i>
                           <div class="info">
                              Pending Memebers
                              <span>
                                 <a href='members.php?page=Pending'><?php echo  CheckItem("RegStatus","users" , 0)?></a>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="stat st-items">
                           <i class="fa fa-tag"></i>
                           <div class="info">
                              Total Items
                              <span>
                                 <a href="Items.php"><?php echo countItems( 'Item_ID' , 'items' ) ?></a>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="stat st-comments">
                           <i class="fa fa-comments"></i>
                           <div class="info">
                              Total Comments
                              <span>
                              <a href="comments.php"><?php echo countItems( 'c_id' , 'comments' ) ?></a>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
         </div>

         <div class="latest">
            <div class="container latest">
               <div class="row">
                  <div class="col-sm-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-users"></i> Latest <?php echo $numUsers ?> Registerd Users
                           <span class="toggle-info pull-right">
                              <i class="fa fa-plus fa-lg"></i>
                           </span>
                        </div>
                        <div class="panel-body">
                           <ul class="list-unstyled latest-users">
                              <?php 
                                    if (! empty($latestUsers)) {
                                    foreach ($latestUsers as $user) {

                                       // echo '<li>' . $user['UserName'] . '<a href="members.php?action=Edit&userid=' . $user['UserID'] . '"<span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</span></a></li>'; 
                                       echo '<li>';
                                          echo $user['UserName'];
                                          echo '<a href="members.php?action=Edit&userid=' . $user['UserID'] . '">';
                                                echo '<span class="btn btn-success pull-right">';
                                                   echo '<i class="fa fa-edit"></i>Edit</a>';
                                                   if ($user['RegStatus'] == 0) {
                                                      echo 
                                                         "<a href='members.php?action=Activate&userid=" . $user['UserID'] . "' 
                                                         class='btn btn-info pull-right activate'>
                                                         <i class='fa fa-check'></i> Activate</a>";
                                                   
                                                   }
                                                echo '</span>';
                                          echo '</a>';
                                       echo '</li>';  
                                    }
                                 } else {
                                    echo 'Ther\'s No Members To Show';
                                 }
                              ?>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-tags"></i> Latest  <?php echo $numItems ?> Items
                           <span class="toggle-info pull-right">
                              <i class="fa fa-plus fa-lg"></i>
                           </span>
                        </div>
                        <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                              <?php 
                                    if (! empty($latestItems)) {
                                       foreach ($latestItems as $item) {

                                          // echo '<li>' . $user['UserName'] . '<a href="members.php?action=Edit&userid=' . $user['UserID'] . '"<span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</span></a></li>'; 
                                          echo '<li>';

                                             echo $item['Name'];
                                             echo '<a href="Items.php?action=Edit&itemid=' . $item['Item_ID'] . '">';
                                                   echo '<span class="btn btn-success pull-right">';
                                                      echo '<i class="fa fa-check"></i>Edit</a>';

                                                      if ($item['Approve'] == 0) {
                                                            echo 
                                                               "<a href='Items.php?action=Approve&itemid=" . $item['Item_ID'] . "' 
                                                               class='btn btn-info pull-right activate'>
                                                               <i class='fa fa-check'></i> Approve</a>";
                                                      
                                                      }
                                                   echo '</span>';
                                             echo '</a>';
                                          echo '</li>';
                                             
                                       }
                                    } else {
                                       echo 'Ther\'s No Items To Show';
                                    }
                              ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Start The Comments -->
               <div class="row">
                  <div class="col-sm-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-comments-o fa-lg"></i> Comments  <?php echo $numComments ?>  Users
                           <span class="toggle-info pull-right">
                              <i class="fa fa-plus fa-lg"></i>
                           </span>
                        </div>
                        <div class="panel-body">
                        <?php
                                
                        // Select All User Except Admin  
                        $stmt = $con->prepare(" SELECT 
                                                      comments.*,users.UserName AS Member
                                                FROM 
                                                      comments
                                                INNER JOIN
                                                      users
                                                ON
                                                      users.UserId = comments.user_id
                                                ORDER BY 
                                                      c_id 
                                                DESC
                                                LIMIT  $numComments");
                        $stmt->execute();
                        $comments = $stmt->fetchAll();
                        
                        if (! empty($comments)) {
                           // <span class='member-n'>' . $comment['Member'] . '</span>
                           foreach($comments as $comment) {
                              echo '<div class="comment-box">';
                              echo '<span class="member-n">
                                    <a href="members.php?action=Edit&userid=' .$comment['user_id'] . '">
                                       ' . $comment['Member'] . '</a></span>';
                              echo '<p class="comment-c">' . $comment['comment'] . '</p>';
                              echo '</div>';
                           }
                        } else {
                           echo 'Ther\'s No Comments To Show';
                        }
                        ?>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End The Comments -->
            </div>
         </div>


         <!-- /* End The Dashboard Page */ -->
<?php
        include $tep . 'footer.php'; 

     } else {

        header('Location: index.php');
        exit();

     }

     ob_end_flush();

?>