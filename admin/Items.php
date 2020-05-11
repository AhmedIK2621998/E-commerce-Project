<?php

    /*
    =========================================================
    === This Page It To Mange Items Page
    === You Can Edit | Add | Delete Items From Here
    =========================================================
    */
    
     ob_start();

     session_start();

     $pageTitle= 'Items';

     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا

        include 'init.php';
        
        $action = isset($_GET['action']) ? $_GET['action']: 'Manage';    // IF CONDITION

        if ($action == 'Manage') { // Start  Manage Page 
            
                $stmt = $con->prepare("SELECT 
                                            items.*,
                                            categories.Name As category_name,
                                            users.UserName 
                                        FROM 
                                            items
                                        INNER JOIN 
                                            categories 
                                        ON 
                                            categories.ID = items.Cat_ID
                                        INNER JOIN 
                                            users 
                                        ON 
                                            users.UserID = items.Member_ID 
                                        ORDER BY 
                                            Item_ID 
                                        DESC");

                // Execute The Statment
                $stmt->execute();

                // Assign To Variable
                $items = $stmt->fetchAll();
        
                if( ! empty($items)) {
                ?>
                <h1 class="text-center">Manage Items</h1>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table text-center table table-bordered">
                            <tr>
                                <td>#ID</td>
                                <td>#Name</td>
                                <td>#Description</td>
                                <td>#Price</td>
                                <td>#Adding Date</td>
                                <td>#Category</td>
                                <td>#Username</td>
                                <td>#Control</td>
                            </tr>

                            <?php 

                                foreach ($items as $item) {

                                    echo '<tr>';
                                        echo "<td>" . $item['Item_ID'] . "</td>";
                                        echo "<td>" . $item['Name'] . "</td>";
                                        echo "<td>" . $item['Description'] . "</td>";
                                        echo "<td>" . $item['Price'] . "</td>";
                                        echo "<td>" . $item['Add_Date'] . "</td>";
                                        echo "<td>" . $item['category_name'] . "</td>";
                                        echo "<td>" . $item['UserName'] . "</td>";
                                        echo "<td>
                                            <a href='Items.php?action=Edit&itemid=" . $item['Item_ID'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                            <a href='Items.php?action=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                            if ($item['Approve'] == 0) {
                                                echo "<a 
                                                        href='Items.php?action=Approve&itemid=" . $item['Item_ID'] . "' 
                                                        class='btn btn-info activate'>
                                                        <i class='fa fa-check'></i> Approve</a>";
                                             }
                                        echo "</td>";
                                    echo '</tr>';

                                }
                            
                            // ?>
                        </table>
                    </div>
                    <a href="Items.php?action=Add" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Item
                    </a>
                </div>

                <?php } else {
                    echo '<div class="container">';
                        echo '<div class="nice-message">There\'s No Items To Show</div>';
                        echo '<a href="Items.php?action=Add" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add New Item
                             </a>';
                    echo '</div>';
                }
            ?>
                <?php

        } elseif ($action == 'Add') { ?>
            
            <h1 class="text-center">Add New Item </h1>
            <div class="container">
            <form class="form-horizontal" action="?action=Insert" method="POST">
             <!-- Start Name Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-8">
                        <input 
                            type="text" 
                            name="name"
                            class="form-control" 
                            required="required"
                            placeholder="Name Of The Item">
                    </div>
            </div>
            <!-- End Name Field -->

            <!-- Start Description Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-8">
                        <input 
                            type="text" 
                            name="description"
                            class="form-control" 
                            required="required"
                            placeholder="Description Of The Item">
                    </div>
            </div>
            <!-- End Description Field -->

            <!-- Start Price Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-8">
                        <input 
                            type="text" 
                            name="price"
                            class="form-control" 
                            required="required"
                            placeholder="Price Of The Item">
                    </div>
            </div>
            <!-- End Price Field -->
            
            <!-- Start Countery_Made Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Countery Of Made</label>
                    <div class="col-sm-10 col-md-8">
                        <input 
                            type="text" 
                            name="countery"
                            class="form-control" 
                            required="required"
                            placeholder="Countery Of Made">
                    </div>
            </div>
            <!-- End Countery_Made Field -->

            <!-- Start Status Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-8">
                        <select class="form-control" name="status">
                            <option value="0">....</option>
                            <option value="1">New</option>
                            <option value="2">Like New</option>
                            <option value="3">Used</option>
                            <option value="4">Very Old</option>
                        </select>
                    </div>
            </div>
            <!-- End Status Field -->
            
            <!-- To Make The Primary Key With Member And Items It Added -->
            <!-- Start Members Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Member</label>
                    <div class="col-sm-10 col-md-8">
                        <select class="form-control" name="member">
                            <option value="0">....</option>
                            <?php
                                $allMembers = getAllFrom("*", "users", "", "", "UserID", "");
                                $stmt = $con->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($allMembers as $user) {
                                    echo "<option value='" . $user['UserID'] ."'>" . $user['UserName'] ."</option>";
                                }
                            ?>
                        </select>
                    </div>
            </div>
            <!-- End Members Field -->
            <!-- To Make The Primary Key With Category And Items It Added -->
            <!-- Start Category Field  -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Category</label>
                    <div class="col-sm-10 col-md-8">
                        <select class="form-control" name="category">
                            <option value="0">....</option>
                            <?php
                                $allCtas = getAllFrom("*", "categories", "Where parent = 0", "", "ID", "");
                                foreach ($allCtas as $cat) {
                                    echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] ."</option>";
                                        $childCtas = getAllFrom("*", "categories", "Where parent = {$cat['ID']}", "", "ID");
                                        foreach ($childCtas as $child) {
                                            echo "<option value='" . $child['ID'] ."'>----" . $child['Name'] . "  Child Form =>  ". $cat['Name'] ."</option>";
                                        }
                                    
                                }
                            ?>
                        </select>
                    </div>
            </div>
            <!-- End Category Field -->
            <!-- Start The Tags Field -->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Tags</label>
                <div class="col-sm-10 col-md-8">
                    <input 
                        type="text"
                        name="tags"
                        class="form-control"
                        placeholder="Separate tags with comma (,)">
                </div>
            </div>
            <!-- End The Tags Field -->
            <!-- Start Submit button -->
            <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Item" class="btn btn-primary btn-2x">
                    </div>
            </div>
            <!-- End submit Field -->
            </form>
        </div>

        <?php

        } elseif ($action == 'Insert') {

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    echo "<h1 class='text-center'>Insert Item</h1>";
                    echo "<div class='container'>";

                    // Get The Data From The Form

                    $name      = $_POST['name'];
                    $desc      = $_POST['description'];
                    $price     = $_POST['price'];
                    $countery  = $_POST['countery'];
                    $status    = $_POST['status'];
                    $member    = $_POST['member'];
                    $cat       = $_POST['category'];
                    $tags      = $_POST['tags'];

                    // Validate The Form    [ SERVER SIDE VALIDATE ]  php هذا هو السرفر سايد فاليديت باستخدام 

                    $formError = array();
                    
                    if(empty($name)) {

                        $formError[] = 'The Name Can\'t Be <strong>Empty</strong>';
                    }
                    if(empty($desc)) {

                        $formError[] = 'The Description Can\'t Be <strong>Empty</strong>';
                    }
                    if(empty($price)) {

                        $formError[] = 'The Price Can\'t Be <strong>Empty</strong>';
                    }
                    if(empty($countery)) {

                        $formError[] = 'The Countery Can\'t Be <strong>Empty</strong>';
                    }
                    if($status == 0) {

                        $formError[] = 'You Must Choose The <strong>Status</strong>';
                    }
                    if($member == 0) {

                        $formError[] = 'You Must Choose The <strong>Member</strong>';
                    }
                    if($cat == 0) {

                        $formError[] = 'You Must Choose The <strong>Category</strong>';
                    }


                    foreach ($formError as $error ) {

                            echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                    // Check If Ther's No Proccesd The Update Operation لو كل الحاجات اللي فوق عدي منها 
                    
                    if(empty($formError)) {
                            
                        // Make Insert  For This Value In Datbase

                        $stmt = $con->prepare("INSERT INTO 
                                            items(`Name`, `Description`, Price, Countery_Made, `Status`, Add_Date, Cat_ID, Member_ID, tags )
                                            VALUES(:zname, :zdesc, :zprice, :zcountery, :zstatus, now(), :zcat, :zmeber, :ztags)" );
                        $stmt->execute(array(

                            'zname'         => $name, 
                            'zdesc'         => $desc, 
                            'zprice'        => $price, 
                            'zcountery'     => $countery, 
                            'zstatus'       => $status, 
                            'zcat'          => $cat ,
                            'zmeber'        => $member,
                            'ztags'         => $tags

                        ));

                            // Echo Success Message 

                        $theMes =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted </div>';

                        redirctHome($theMes, 'back',4);                               
                    
                    }
    
                   } else {

                    echo '<div class="container">';

                    $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                    redirctHome($theMes);

                    echo '</div>';
                }

               echo  "</div>";

        } elseif ($action == 'Edit') {

             //  Check If itemid numeric & get integer value

             $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0 ; 
            
             // Selecet All Data depond On userid

            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
           
            // Execute The Query

            $stmt->execute(array($itemid));
            
            // Fetch The Data

            $item = $stmt->fetch();

            // Row Count

            $count = $stmt->rowCount();

            // If The Ther's userid Show This Form

            if ( $count > 0) { ?>

                <h1 class="text-center"> Edit Item </h1>
                <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <input type="hidden" name="itemid" value="<?php echo $itemid; ?>">
                    <!-- Start Name Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-8">
                                <input 
                                    type="text" 
                                    name="name"
                                    class="form-control" 
                                    placeholder="Name Of The Item"
                                    value="<?php echo $item['Name']?>">
                            </div>
                    </div>
                    <!-- End Name Field -->

                    <!-- Start Description Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-8">
                                <input 
                                    type="text" 
                                    name="description"
                                    class="form-control" 
                                    placeholder="Description Of The Item"
                                    value="<?php echo $item['Description']?>">
                            </div>
                    </div>
                    <!-- End Description Field -->

                    <!-- Start Price Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-8">
                                <input 
                                    type="text" 
                                    name="price"
                                    class="form-control" 
                                    placeholder="Price Of The Item"
                                    Value="<?php echo $item['Price']?>">
                            </div>
                    </div>
                    <!-- End Price Field -->
                    
                    <!-- Start Countery_Made Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Countery Of Made</label>
                            <div class="col-sm-10 col-md-8">
                                <input 
                                    type="text" 
                                    name="countery"
                                    class="form-control"                                 
                                    placeholder="Countery Of Made"
                                    Value="<?php echo $item['Countery_Made']?>">
                            </div>
                    </div>
                    <!-- End Countery_Made Field -->

                    <!-- Start Status Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-8">
                                <select class="form-control" name="status">
                                    <option value="1" <?php if ($item['Status'] == 1) { echo 'Selected'; } ?>>New</option>
                                    <option value="2" <?php if ($item['Status'] == 2) { echo 'Selected'; } ?>>Like New</option>
                                    <option value="3" <?php if ($item['Status'] == 3) { echo 'Selected'; } ?>>Used</option>
                                    <option value="4" <?php if ($item['Status'] == 4) { echo 'Selected'; } ?>>Very Old</option>
                                </select>
                            </div>
                    </div>
                    <!-- End Status Field -->
                    
                    <!-- To Make The Primary Key With Member And Items It Added -->
                    <!-- Start Members Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-8">
                                <select class="form-control" name="member">
                                    <?php
                                        $stmt = $con->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $users = $stmt->fetchAll();
                                        foreach ($users as $user) {
                                            echo "<option value='" . $user['UserID'] ."' "; 
                                            if ($item['Member_ID'] ==  $user['UserID'] ) { echo 'Selected'; }
                                            echo ">" . $user['UserName'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <!-- End Members Field -->
                    <!-- To Make The Primary Key With Category And Items It Added -->
                    <!-- Start Category Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-8">
                                <select class="form-control" name="category">
                                    <?php
                                        $stmt2 = $con->prepare("SELECT * FROM categories");
                                        $stmt2->execute();
                                        $cats = $stmt2->fetchAll();
                                        foreach ($cats as $cat) {
                                            echo "<option value='" . $cat['ID'] ."' ";
                                            if ($item['Cat_ID'] ==   $cat['ID'] ) { echo 'Selected'; }
                                            echo ">" . $cat['Name'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <!-- End Category Field -->
                    <!-- Start The Tags Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Tags</label>
                        <div class="col-sm-10 col-md-8">
                            <input 
                                type="text"
                                name="tags"
                                class="form-control"
                                placeholder="Separate tags with comma (,)"
                                value="<?php echo $item['tags']?>"/>
                        </div>
                    </div>
                    <!-- End The Tags Field -->
                    <!-- Start Submit button -->
                    <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save Item" class="btn btn-primary btn-2x">
                            </div>
                    </div>
                    <!-- End submit Field -->
                </form>
                
                <?php
                        
                // Select All User Except Admin  
                $stmt = $con->prepare("SELECT 
                                                comments.*,users.UserName AS Member
                                            FROM 
                                                comments
                                            INNER JOIN
                                                users
                                            ON
                                                users.UserId = comments.user_id
                                            WHERE 
                                                item_id=?");

                // Execute The Statment
                $stmt->execute(array($itemid));

                // Assign To Variable
                $rows = $stmt->fetchAll();
                
                if ( !empty($rows) ) {
                ?>
                    <h1 class="text-center">Manage [ <?php echo $item['Name'];?> ]Comments</h1>
                            <div class="table-responsive">
                                <table class="main-table text-center table table-bordered">
                                    <tr>
                                        <td>Comment</td>
\                                       <td>User Name</td>
                                        <td>Added Date</td>
                                        <td>#Control</td>
                                    </tr>

                                    <?php 

                                        foreach ($rows as $row) {

                                            echo '<tr>';
                                                echo "<td>" . $row['comment'] . "</td>";
                                                echo "<td>" . $row['Member'] . "</td>";
                                                echo "<td>" . $row['comment_date'] . "</td>";
                                                echo "<td>
                                                    <a href='comments.php?action=Edit&comid=" . $row['c_id'] . "'class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                                    <a href='comments.php?action=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";

                                                    if ($row['status'] == 0) {
                                                            echo "<a 
                                                                    href='comments.php?action=Approve&comid=" . $row['c_id'] . "' 
                                                                    class='btn btn-info activate'>
                                                                    <i class='fa fa-check'></i> Approve </a>";
                                                    
                                                    }
                                                echo "</td>";
                                            echo '</tr>';

                                        }
                                    
                                    // ?>
                                </table>
                            </div>
                       
                            <?php } ?>         
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
            
        } elseif ($action == 'Update') {
                // Update The Userinfo 

                echo "<h1 class='text-center'>Update Item</h1>";
                echo "<div class='container'>";
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Get The Data From The Form

                    $id         = $_POST['itemid'];
                    $name       = $_POST['name'];
                    $desc       = $_POST['description'];
                    $price      = $_POST['price'];
                    $countery   = $_POST['countery'];
                    $status     = $_POST['status'];
                    $cat        = $_POST['category'];
                    $member     = $_POST['member'];
                    $tags       = $_POST['tags'];

                    // Validate The Form    [ SERVER SIDE VALIDATE ]  php هذا هو السرفر سايد فاليديت باستخدام 

                    $formError = array();
                            
                    if(empty($name)) {

                        $formError[] = 'The Name Can\'t Be <strong>Empty</strong>';
                    }
                    if(empty($desc)) {

                        $formError[] = 'The Description Can\'t Be <strong>Empty</strong>';
                    }
                    if(empty($price)) {

                        $formError[] = 'The Price Can\'t Be <strong>Empty</strong>';
                    }
                    if(empty($countery)) {

                        $formError[] = 'The Countery Can\'t Be <strong>Empty</strong>';
                    }
                    if($status == 0) {

                        $formError[] = 'You Must Choose The <strong>Status</strong>';
                    }
                    if($member == 0) {

                        $formError[] = 'You Must Choose The <strong>Member</strong>';
                    }
                    if($cat == 0) {

                        $formError[] = 'You Must Choose The <strong>Category</strong>';
                    }

                    foreach ($formError as $error ) {

                         echo '<div class="alert alert-danger">' . $error . '</div>';
                    }

                    //Check If Ther's No Proccesd The Update Operation لو كل الحاجات اللي فوق عدي منها 
                    
                    if(empty($formError)) {

                        // Make Update For This Value In Datbase

                        $stmt = $con->prepare(" UPDATE 
                                                    items 
                                                SET 
                                                    `Name`          =?, 
                                                    `Description`   =?, 
                                                     Price          =?, 
                                                    `Countery_Made` =?,
                                                    `Status`        =?,
                                                     Cat_ID         =?,
                                                     Member_ID      =?,
                                                     tags           =?
                                                WHERE 
                                                    Item_ID=?");
                        $stmt->execute(array($name, $desc, $price,  $countery , $status, $cat, $member, $tags,$id));

                        // Echo Success Message 

                        $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
                    
                        redirctHome($theMes, 'back');
                    }
                    
                } else {

                    $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                    redirctHome($theMes);
                    
                }

                echo  "</div>";

        } elseif ($action == 'Delete') {
            
            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";

            //  Check If uerid numeric & get integer value

            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0 ; 
                    
            // Selecet All Data depond On itemid

            // $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
            
            $check = CheckItem('Item_ID' ,'items' , $itemid);

            // Execute The Query

            // $stmt->execute(array($userid));
                
            // Fetch The Data

            // $row = $stmt->fetch();

            // If The Ther's userid Show This Form

            if ( $check  > 0) {
                
                // Make Delete From DataBase

                // $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
                $stmt = $con->prepare(" DELETE 
                                        FROM 
                                            items 
                                        WHERE 
                                            Item_ID = :zid");    //Another Way bindparam

                $stmt->bindparam(":zid", $itemid);    // Another Way   الربط بين المتغير والقميه اللي جايه 

                // Execute The Query

                $stmt->execute();

                $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted </div>';
                
                redirctHome($theMes, 'back');

            } else {

                $theMes = '<div class="alert alert-success">The ID Not Exists</div>';

                redirctHome($theMes);

            }
            echo '</div>';

        } elseif ($action == 'Approve') {    // علشان اعمل موافقه علي العنصر اللي هيضاف  
            
                echo "<h1 class='text-center'>Approve Item</h1>";
                echo "<div class='container'>";

                //  Check If Item ID numeric & get integer value

                $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0 ; 
                        
                // Selecet All Data depond On userid
                
                $check = CheckItem('Item_ID' ,'items' , $itemid);


                if ( $check  > 0) {
                    
                    // Make Approve To DataBase

                    $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID=?");    //Another Way bindparam
                    
                    // Execute The Query
                    $stmt->execute(array($itemid));

                    $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved </div>';
                    
                    redirctHome($theMes);

                } else {

                    $theMes = '<div class="alert alert-success">The ID Not Exists</div>';

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
?>