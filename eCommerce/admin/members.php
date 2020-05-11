<?php

    /*
    =========================================================
    === This Page It To Mange Members Page
    === You Can Edit | Add | Delete Member From Here
    =========================================================
    */

     session_start();

     $pageTitle= 'Members';

     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا

        include 'init.php';

        $action = isset($_GET['action']) ? $_GET['action']: 'Manage';    // IF CONDITION

        //  Start Manange Page

        if ($action == 'Manage') { // Start  Manage Page 

            $query = '';

            if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

                $query = "AND RegStatus = 0";
            }
            
                // Select All User Except Admin  
                $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1  $query ORDER BY UserId DESC " );

                // Execute The Statment
                $stmt->execute();

                // Assign To Variable
                $rows = $stmt->fetchAll();

                if(! empty($rows)) {
        
               ?>
               <h1 class="text-center">Manage Members</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table manage-table text-center table table-bordered">
                            <tr>
                                <td>ID</td>
                                <td>Avatar</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Full Name</td>
                                <td>Registerd Date</td>
                                <td>Control</td>
                            </tr>

                            <?php 

                                foreach ($rows as $row) {

                                    echo '<tr>';
                                        echo "<td>" . $row['UserID'] . "</td>";
                                        echo "<td>";
                                        if (empty($row['avatar'])) {
                                            echo "<img class='img-thumbnail img-circle' src='uploads/avatar/default.png' alt=''/>";
                                        } else {
                                            echo "<img class='img-thumbnail img-circle' src='uploads/avatar/" . $row['avatar'] . "' alt=''/>";
                                        }
                                        echo "</td>";
                                        echo "<td>" . $row['UserName'] . "</td>";
                                        echo "<td>" . $row['Email'] . "</td>";
                                        echo "<td>" . $row['FullName'] . "</td>";
                                        echo "<td>" . $row['Date'] . "</td>";
                                        echo "<td>
                                            <a href='members.php?action=Edit&userid=" . $row['UserID'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                            <a href='members.php?action=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

                                            if ($row['RegStatus'] == 0) {
                                                    echo "<a 
                                                            href='members.php?action=Activate&userid=" . $row['UserID'] . "' 
                                                            class='btn btn-info activate'>
                                                            <i class='fa fa-check'></i> Activate</a>";
                                            
                                            }
                                        echo "</td>";
                                    echo '</tr>';
                                }
                            // ?>
                        </table>
                    </div>
                    <a href="members.php?action=Add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Member
                    </a>
                </div>
           
            <?php } else {
                    echo '<div class="container">';
                        echo '<div class="nice-message">There\'s No Members To Show</div>';
                        echo '<a href="members.php?action=Add" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add New Member
                              </a>';
                    echo '</div>';
                }
            ?>

        <?php  } elseif ( $action == 'Add') { // Add New Members ?>

                    <h1 class="text-center">Add New Members</h1>
                    <div class="container">
                    <form class="form-horizontal" action="?action=Insert" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <!-- Start Username Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="text" name="username"class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop">
                            </div>
                    </div>
                    <!-- End Username Field -->

                    <!-- Start Password Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Passwrod</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="password" name="password" class="password form-control" required="required" autocomplete="new-password" placeholder="Password Must Be Hard & Complex">
                                 <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                    </div>
                    <!-- End Password Field -->

                    <!-- Start Email Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="Email" name="Email"class="form-control" autocomplete="off" required="required" placeholder="Email Must Be Valid">
                            </div>
                    </div>
                    <!-- End Username Field -->

                    <!-- Start Fullname Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Fullname</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="text" name="Fullname" class="form-control" autocomplete="off" required="required" placeholder="Enter The Fullname To Appear In Profile Page">
                            </div>
                    </div>
                    <!-- End Username Field -->

                    <!-- Start User Image Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">User Avatar</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="file" name="avatar" required="required" class="form-control" />
                            </div>
                    </div>
                    <!-- End User Image Field -->

                    <!-- Start Submit button -->
                    <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add Members" class="btn btn-primary btn-lg">
                            </div>
                    </div>
                    <!-- End submit Field -->
                    </form>
                </div>

        <?php 
               } elseif ($action == 'Insert') {

                // Insert Member Page
                

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    echo "<h1 class='text-center'>Insert Members</h1>";
                    echo "<div class='container'>";

                    // Upload The File 

                    $avatarName     = $_FILES['avatar']['name'];
                    $avatarSize     = $_FILES['avatar']['size'];
                    $avatarTmp      = $_FILES['avatar']['tmp_name'];
                    $avatarType     = $_FILES['avatar']['type'];

                    // List Of Allowed File Typed To Upload

                    $avatarAllowedExtension = array("jpeg","jpg","gif","png");

                    // Get Avatar Extension

                    // The Function Of expolde() It Divid The The String Into Array When I add to end Mening Give Me The Last Array
 
                    $explod = explode('.', $avatarName);

                    $avatarExtension = strtolower(end($explod));


                    // Get The Data From The Form

                    $user = $_POST['username'];
                    $pass = $_POST['password'];
                    $email = $_POST['Email'];
                    $name = $_POST['Fullname'];
                    $hashdpass = sha1($_POST['password']); 
                    // Password Trick   هنا ممكن وانا بعدل بيانات الادمن ممكن اسيب حقل الباسورد فاضي فابالتالي هو هيسجل بكلمه السر القديمه
                    //                  ولكن لو عايزه يعمل باسورد جديده هعمل باسورد عادي بس يكون مشفر
                    
                    // Validate The Form    [ SERVER SIDE VALIDATE ]  php هذا هو السرفر سايد فاليديت باستخدام 

                    $formError = array();
                    
                    if(strlen($user) < 4 ) {

                        $formError[] = 'The UserName Can\'t Be Less <strong>4 Characters</strong>';
                    }
                    if(strlen($user) > 20 ) {

                        $formError[] = 'The UserName Can\'t Be More <strong>20 Characters</strong>';
                    }
                    if(empty($user)) {

                        $formError[] = 'The UserName Can\'t <strong>Empty</strong>';
                    }
                    if(empty($pass)) {

                        $formError[] = 'The Password Can\'t <strong>Empty</strong>';
                    }
                    if(empty($email)) {

                        $formError[] = 'The Email Can\'t <strong>Empty</strong>';
                    }
                    if(empty($name)) {

                        $formError[] = 'The Full Name Can\'t Be <strong>Empty</strong>';
                    }
                    if(!empty($avatarName) && ! in_array($avatarExtension,$avatarAllowedExtension)) {

                        $formError[] = 'The Extension Is Not <strong>Allowed</strong>'; 
                    }
                    if(empty($avatarName)) {

                        $formError[] = 'Avatar Is <strong>Required</strong>'; 
                    }
                    if($avatarSize > 4194304) {

                        $formError[] = 'Avatar Can\'t Be Larger Than <strong>4MB</strong>'; 
                    }
                    foreach ($formError as $error ) {

                            echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                  
                    //Check If Ther's No Proccesd The Update Operation لو كل الحاجات اللي فوق عدي منها 
                    
                    if(empty($formError)) {

                        $avatar = rand(0,100000000) . '_' . $avatarName;

                        move_uploaded_file($avatarTmp, "uploads\avatar\\" . $avatar);

                        // Check If The User  Exists In Data Base

                        $check = CheckItem("UserName","users",$user);

                        if ($check == 1) {

                            $theMes = '<div class="alert alert-danger">Sorry This User Is Exists</div>';

                            redirctHome($theMes,'back');
                        } else {
                            
                                // Make Insert  For This Value In Datbase

                                $stmt = $con->prepare("INSERT INTO 
                                                    users(UserName, `Password`, Email, FullName, RegStatus, Date, avatar )
                                                    VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar) " );
                                $stmt->execute(array(

                                    'zuser'   => $user, 
                                    'zpass'   => $hashdpass, 
                                    'zmail'   => $email, 
                                    'zname'   => $name,
                                    'zavatar' => $avatar

                                ));

                                    // Echo Success Message 

                                $theMes =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted </div>';

                                redirctHome($theMes, 'back',4);                               
                             }
                             
                        }
    
                } else {

                    echo '<div class="container">';

                    $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                    redirctHome($theMes);

                    echo '</div>';
                }

               echo  "</div>";
     
        } elseif( $action == 'Edit') {// Edit Page
            
            //  Check If uerid numeric & get integer value

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0 ; 
            
             // Selecet All Data depond On userid

            $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
           
            // Execute The Query

            $stmt->execute(array($userid));
            
            // Fetch The Data

            $row = $stmt->fetch();

            // Row Count

            $count = $stmt->rowCount();

            // If The Ther's userid Show This Form

            if ( $count > 0) { ?>

                        <h1 class="text-center">Edit Members</h1>
                        <div class="container">
                        <form class="form-horizontal" action="?action=Update" method="POST">
                            <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                        <!-- Start Username Field To Edit -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                                <div class="col-sm-10 col-md-8">
                                    <input type="text" name="username" value="<?php echo $row['UserName']; ?>"class="form-control" autocomplete="off" required="required">
                                </div>
                        </div>
                        <!-- End Username Field -->

                        <!-- Start Password Field To Edit -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Passwrod</label>
                                <div class="col-sm-10 col-md-8">
                                    <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
                                    <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave This Input If You Don\'t Enter Password">
                                </div>
                        </div>
                        <!-- End Password Field -->

                        <!-- Start Email Field To Edit -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10 col-md-8">
                                    <input type="Email" name="Email" value="<?php echo $row['Email']; ?>" class="form-control" autocomplete="off" required="required">
                                </div>
                        </div>
                        <!-- End Username Field -->

                        <!-- Start Fullname Field To Edit -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Fullname</label>
                                <div class="col-sm-10 col-md-8">
                                    <input type="text" name="Fullname" value="<?php echo $row['FullName']; ?>" class="form-control" autocomplete="off" required="required">
                                </div>
                        </div>
                        <!-- End Username Field -->

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

                        $id = $_POST['userid'];
                        $user = $_POST['username'];
                        $email = $_POST['Email'];
                        $name = $_POST['Fullname'];

                        // Password Trick   هنا ممكن وانا بعدل بيانات الادمن ممكن اسيب حقل الباسورد فاضي فابالتالي هو هيسجل بكلمه السر القديمه
                        //                  ولكن لو عايزه يعمل باسورد جديده هعمل باسورد عادي بس يكون مشفر
                        
                        // Condtion ? True : False

                        $pass = empty($_POST['newpassword']) ?  $_POST['oldpassword'] : sha1($_POST['newpassword']);
                        
                        // Validate The Form    [ SERVER SIDE VALIDATE ]  php هذا هو السرفر سايد فاليديت باستخدام 

                       
                    $formError = array();
                    
                    if(strlen($user) < 4 ) {

                        $formError[] = 'The UserName Can\'t Be Less <strong>4 Characters</strong>';
                    }
                    if(strlen($user) > 20 ) {

                        $formError[] = 'The UserName Can\'t Be More <strong>20 Characters</strong>';
                    }
                    if(empty($user)) {

                        $formError[] = 'The UserName Can\'t <strong>Empty</strong>';
                    }
                    if(empty($pass)) {

                        $formError[] = 'The Password Can\'t <strong>Empty</strong>';
                    }
                    if(empty($email)) {

                        $formError[] = 'The Email Can\'t <strong>Empty</strong>';
                    }
                    if(empty($name)) {

                        $formError[] = 'The Full Name Can\'t Be <strong>Empty</strong>';
                    }

                    foreach ($formError as $error ) {

                            echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                        //Check If Ther's No Proccesd The Update Operation لو كل الحاجات اللي فوق عدي منها 

                        if(empty($formError)) {

                            $stmt2 = $con->prepare("SELECT 
                                                        *
                                                    FROM 
                                                        users 
                                                    WHERE 
                                                        UserName =? 
                                                    AND 
                                                        UserID != ?");

                            $stmt2->execute(array($user,$id));

                            $count = $stmt2->rowCount();

                            if ($count ==1) {

                                $theMes = '<div class="alert alert-danger">Sorry This User Is Exists</div>';

                                redirctHome($theMes, 'back');
                            } else {

                            // Make Update For This Value In Datbase

                            $stmt = $con->prepare("UPDATE users SET UserName=?, Email=?, FullName=?, `Password`=? WHERE UserID=?");
                            $stmt->execute(array($user, $email, $name,  $pass , $id));

                            // Echo Success Message 

                            $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
                        
                            redirctHome($theMes, 'back');
                            
                            }
                        }
                        
                    } else {

                        $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                        redirctHome($theMes);
                        
                    }

                   echo  "</div>";

            } elseif ($action == 'Delete') {   // Delete The Members From Page


                    echo "<h1 class='text-center'>Delete Member</h1>";
                    echo "<div class='container'>";

                    //  Check If uerid numeric & get integer value

                    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0 ; 
                            
                    // Selecet All Data depond On userid

                    //  $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
                    
                    $check = CheckItem('userid' ,'users' , $userid);

                    // Execute The Query

                    // $stmt->execute(array($userid));
                        
                    // Fetch The Data

                    // $row = $stmt->fetch();

                    // If The Ther's userid Show This Form

                    if ( $check  > 0) {
                        
                        // Make Delete From DataBase

                        // $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
                        $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");    //Another Way bindparam

                        $stmt->bindparam(":zuser", $userid);    // Another Way   الربط بين المتغير والقميه اللي جايه 

                        // Execute The Query

                        $stmt->execute();

                        $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted </div>';
                        
                        redirctHome($theMes ,'back');

                    } else {

                        $theMes = '<div class="alert alert-success">The ID Not Exists</div>';

                        redirctHome($theMes);

                    }
                    echo '</div>';

             } elseif ($action == 'Activate') {

                        echo "<h1 class='text-center'>Delete Member</h1>";
                        echo "<div class='container'>";

                        //  Check If uerid numeric & get integer value

                        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0 ; 
                                
                        // Selecet All Data depond On userid
                        
                        $check = CheckItem('userid' ,'users' , $userid);


                        if ( $check  > 0) {
                            
                            // Make Activate To DataBase

                            $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID=?");    //Another Way bindparam
                            
                            // Execute The Query
                            $stmt->execute(array($userid));

                            $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activates </div>';
                            
                            redirctHome($theMes);

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