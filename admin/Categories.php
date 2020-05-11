<?php

    /*
    =========================================================
    === This Page It To Mange Members Page
    === You Can Edit | Add | Delete Member From Here
    === Categories Page
    =========================================================
    */

     ob_start(); 

     session_start();

     $pageTitle= 'Categories';

     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا

        include 'init.php';
        
        $action = isset($_GET['action']) ? $_GET['action']: 'Manage';    // IF CONDITION

        if ($action == 'Manage') { // Start  Manage Page 

            $sort = 'asc';

            $sort_array = array('asc','desc');

            if ( isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

                $sort = $_GET['sort'];
            }
            $stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");
            
            $stmt2->execute();

            $cats = $stmt2->fetchAll(); 
            
            if(! empty($cats)) {

            ?>

                <h1 class="text-center">Manage Categories</h1>
                <div class="container categories">
                    <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-edit"></i> Manage Categories
                        <div class='option pull-right'>
                            <i class="fa fa-sort"></i> Ordering:[
                            <a class="<?php if ($sort == 'asc'){ echo 'active'; }?>" href="?sort=asc"> ASC</a> | 
                            <a class="<?php if ($sort == 'desc'){ echo 'active'; }?>" href="?sort=desc">DESC</a>]
                            <i class="fa fa-eye"></i> View:[
                            <span class="active" data-view="full">Full</span> |
                            <span data-view="classic">Classic</span>]
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php
                            foreach($cats as $cat) {
                                echo "<div class='cat'>";
                                echo "<div class='hidden-buttons'>";
                                    echo "<a href='Categories.php?action=Edit&catid=".  $cat['ID'] . "'class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                                    echo "<a href='Categories.php?action=Delete&catid=".  $cat['ID'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                                echo "</div>";
                                echo "<h3>" .  $cat['Name'] . "</h3>";
                                    echo "<div class='full-view'>";   
                                        echo "<p>"; if($cat['Description'] == '') { echo 'This Category has no description'; } else { echo $cat['Description']; } echo "</p>"; 
                                        if ($cat['Visibility'] == 1 ) { echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';}
                                        if ($cat['Allow_Comment'] == 1 ) { echo '<span class="commenting"><i class="fa fa-close"></i> Disabeld Comment</span>';}
                                        if ($cat['Allow_Ads'] == 1 ) { echo '<span class="Advertises"><i class="fa fa-close"></i> Ads Disabeld</span>';} 
                                    echo "</div>";
                                    
                                    // Get Child Category From Parent

                                    $ChildCats = getAllFrom("*", "categories", "Where parent = {$cat['ID']}", "", "ID" , "ASC");
                                    if (! empty($ChildCats)) {

                                        echo "<h4 class='child-head'>Chiled Category</h4>";
                                        echo "<ul class='list-unstyled child-cats'>";
                                        foreach ($ChildCats as $ch) {
                                            echo "<li  class='child-cat'>
                                            <a href='Categories.php?action=Edit&catid=".  $ch['ID'] . "'>" . $ch['Name'] . "</a>
                                            <a href='Categories.php?action=Delete&catid=".  $ch['ID'] . "' class='show-delete confirm'>Delete</a>
                                            </li>"; 
                                        }
                                        echo "</ul>";
                                    }
                                echo "</div>";                   
                                echo "<hr>";
                            }
                        ?>
                    </div>
                    </div>
                    <a class="add-category btn btn-primary"href="Categories.php?action=Add"><i class="fa fa-plus"></i> Add New Category </a>
                </div>

                <?php } else {
                    echo '<div class="container">';
                        echo '<div class="nice-message">There\'s No Categories To Show</div>';
                        echo '<a href="Categories.php?action=Add" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add New Categories
                              </a>;';
                    echo '</div>';
                }
            ?>
        <?php
        } elseif ($action == 'Add') { ?>

            
                <h1 class="text-center">Add New Category</h1>
                <div class="container">
                <form class="form-horizontal" action="?action=Insert" method="POST">
                 <!-- Start Name Field  -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" name="name"class="form-control" autocomplete="off"
                             required="required" placeholder="Name Of The Category">
                        </div>
                </div>
                <!-- End Name Field -->

                <!-- Start Description Field To Edit -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" name="description" class="form-control"
                             placeholder="Describe The Category" />
                        </div>
                </div>
                <!-- End Description Field -->

                <!-- Start Ordering Field To Edit -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-8">
                            <input type="text" name="ordering"class="form-control" autocomplete="off" 
                            placeholder="Arrange The Category" />
                        </div>
                </div>
                <!-- End Ordering Field -->
                <!-- Start Category Type -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Parent?</label>
                        <div class="col-sm-10 col-md-8">
                        <select name="parent" class="form-control">
                            <option value="0">None</option>
                            <?php
                                $allCats = getAllFrom("*", "categories", "where parent = 0","", "ID" , "ASC");
                                foreach ($allCats as $cat) {
                                    echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                                }
                            ?>
                        </select>
                        </div>
                </div>
                <!-- End Category Type -->
                <!-- Start Visibility Field To Edit -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visibile</label>
                        <div class="col-sm-10 col-md-8">
                            <div>
                                <input id="vis-yes" type="radio" name="visibilty" value="0" checked>
                                <label for="vis-yes">yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibilty" value="1" >
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                </div>
                <!-- End Visibility Field -->

                <!-- Start Allow Commenting Field To Edit -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Commenting</label>
                        <div class="col-sm-10 col-md-8">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0" checked>
                                <label for="com-yes">yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" >
                                <label for="com-no">No</label>
                            </div>
                        </div>
                </div>
                <!-- End Allow Commenting Field -->
                
                <!-- Start Allow ِdvertisement Field To Edit -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label"> Allow Ads </label>
                        <div class="col-sm-10 col-md-8">
                            <div>
                                <input id="Ads-yes" type="radio" name="Ads" value="0" checked>
                                <label for="Ads-yes">yes</label>
                            </div>
                            <div>
                                <input id="Ads-no" type="radio" name="Ads" value="1" >
                                <label for="Ads-no">No</label>
                            </div>
                        </div>
                </div>
                <!-- End Allow ِdvertisement Field -->
                <!-- Start Submit button -->
                <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Category" class="btn btn-primary btn-lg">
                        </div>
                </div>
                <!-- End submit Field -->
                </form>
            </div>


        <?php } elseif ($action == 'Insert') {

              // Insert Category Page
            
              if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                echo "<h1 class='text-center'>Insert Category</h1>";
                echo "<div class='container'>";

                // Get The Data From The Form

                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $parent     = $_POST['parent'];
                $order      = $_POST['ordering'];
                $visible    = $_POST['visibilty'];
                $comment    = $_POST['commenting'];
                $Ads        = $_POST['Ads'];
                
                // if(empty($formError)) {

                    // Check If The Category  Exists In Data Base

                    $check = CheckItem("Name","categories",$name);

                    if ($check == 1) {

                        $theMes = '<div class="alert alert-danger">Sorry This Category Is Exists</div>';

                        redirctHome($theMes,'back');
                    } else {
                        
                            // Make Insert  For This Value Of Category In Datbase

                            $stmt = $con->prepare("INSERT INTO 
                                                categories(`Name`, `Description`, parent, Ordering, Visibility, Allow_Comment, Allow_Ads )
                                                VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads) 
                                                   ");
                            $stmt->execute(array(

                                'zname'     => $name , 
                                'zdesc'     => $desc, 
                                'zparent'   => $parent, 
                                'zorder'    => $order, 
                                'zvisible'  => $visible, 
                                'zcomment'  => $comment, 
                                'zads'      => $Ads

                            ));

                                // Echo Success Message 

                            $theMes =  "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted </div>';

                            redirctHome($theMes, 'back',4);                               
                        //  }
                    }

                } else {

                    echo '<div class="container">';

                    $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                    redirctHome($theMes, 'back');

                    echo '</div>';
                }

              echo  "</div>";
 

        } elseif ($action == 'Edit') {
   
            //  Check If catid numeric & get integer value

            $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0 ; 
            
             // Selecet All Data depond On UserId

            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
           
            // Execute The Query

            $stmt->execute(array($catid));
            
            // Fetch The Data

            $cat = $stmt->fetch();

            // Row Count

            $count = $stmt->rowCount();

            // If The Ther's userid Show This Form

            if ( $count > 0) { ?>

                    <h1 class="text-center">Edit Category</h1>
                    <div class="container">
                    <form class="form-horizontal" action="?action=Update" method="POST">
                        <input type="hidden" name="catid" value="<?php echo $catid; ?>">
                    <!-- Start Name Field  -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="text" name="name"class="form-control"
                                required="required" placeholder="Name Of The Category" value="<?php echo $cat['Name']?>">
                            </div>
                    </div>
                    <!-- End Name Field -->

                    <!-- Start Description Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="text" name="description" class="form-control"
                                placeholder="Describe The Category" value="<?php echo $cat['Description']?>">
                            </div>
                    </div>
                    <!-- End Description Field -->

                    <!-- Start Ordering Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10 col-md-8">
                                <input type="text" name="ordering"class="form-control"
                                placeholder="Arrange The Category" value="<?php echo $cat['Ordering']?>">
                            </div>
                    </div>
                    <!-- End Ordering Field -->
                    <!-- Start Category Type -->
                    <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Parent?</label>
                        <div class="col-sm-10 col-md-8">
                            <select name="parent" class="form-control">
                                <option value="0">None</option>
                                <?php
                                    $allCats = getAllFrom("*", "categories", "where parent = 0","", "ID" , "ASC");
                                    foreach ($allCats as $c) {
                                        echo "<option value='" . $c['ID'] . "'";
                                        if ($cat['parent'] == $c['ID']) { echo 'selected'; }
                                        echo ">" . $c['Name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                     </div>
                    <!-- End Category Type -->
                    <!-- Start Visibility Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visibile</label>
                            <div class="col-sm-10 col-md-8">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibilty" value="0" <?php if($cat['Visibility'] == 0) {echo 'checked';} ?> >
                                    <label for="vis-yes">yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibilty" value="1" <?php if($cat['Visibility'] == 1) {echo 'checked';} ?> >
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                    </div>
                    <!-- End Visibility Field -->

                    <!-- Start Allow Commenting Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Commenting</label>
                            <div class="col-sm-10 col-md-8">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) {echo 'checked';} ?>>
                                    <label for="com-yes">yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) {echo 'checked';} ?>>
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                    </div>
                    <!-- End Allow Commenting Field -->
                    
                    <!-- Start Allow ِdvertisement Field To Edit -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label"> Allow Ads </label>
                            <div class="col-sm-10 col-md-8">
                                <div>
                                    <input id="Ads-yes" type="radio" name="Ads" value="0" <?php if($cat['Allow_Ads'] == 0) {echo 'checked';} ?> >
                                    <label for="Ads-yes">yes</label>
                                </div>
                                <div>
                                    <input id="Ads-no" type="radio" name="Ads" value="1" <?php if($cat['Allow_Ads'] == 1) {echo 'checked';} ?>>
                                    <label for="Ads-no">No</label>
                                </div>
                            </div>
                    </div>
                    <!-- End Allow ِdvertisement Field -->
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

        } elseif ($action == 'Update') {

                // Update The Category 

                echo "<h1 class='text-center'>Update Category</h1>";
                echo "<div class='container'>";
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                // Get The Data From The Form

                $id         = $_POST['catid'];
                $name       = $_POST['name'];
                $desc       = $_POST['description'];
                $order      = $_POST['ordering'];
                $parent      = $_POST['parent'];
                $visible    = $_POST['visibilty'];
                $comment    = $_POST['commenting'];
                $Ads        = $_POST['Ads'];
                
                    // Make Update For This Value In Datbase

                    $stmt = $con->prepare("UPDATE 
                                                categories 
                                            SET 
                                                `Name`          =?, 
                                                `Description`   =?, 
                                                Ordering        =?, 
                                                parent          =?,
                                                Visibility      =?,
                                                Allow_Comment   =?,
                                                Allow_Ads       =? 
                                            WHERE 
                                                ID=?");

                    $stmt->execute(array($name, $desc, $order, $parent, $visible , $comment, $Ads, $id));

                    // Echo Success Message 

                    $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated </div>';
                
                    redirctHome($theMes, 'back');
                    
                } else {

                    $theMes = '<div class="alert alert-danger">Sorry You Can\'t Browse This Page Dirctly</div>';

                    redirctHome($theMes);
                    
                }

                echo  "</div>";

        } elseif ($action == 'Delete') {
                
                
                echo "<h1 class='text-center'>Delete Category</h1>";
                echo "<div class='container'>";

                //  Check If Catid numeric & get integer value

                $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']): 0 ; 
                        
                // Selecet All Data depond On Catid

                //  $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");  //  stmt ==> statment And GroupId Should be =1 Tobe Admin
                
                $check = CheckItem('ID' ,'categories' , $catid);

                // Execute The Query

                // $stmt->execute(array($userid));
                    
                // Fetch The Data

                // $row = $stmt->fetch();

                // If The Ther's userid Show This Form

                if ( $check  > 0) {
                    
                    // Make Delete From DataBase

                    // $stmt = $con->prepare("DELETE FROM users WHERE UserID = ?");
                    $stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");    //Another Way bindparam

                    $stmt->bindparam(":zid", $catid);    // Another Way   الربط بين المتغير والقميه اللي جايه 

                    // Execute The Query

                    $stmt->execute();

                    $theMes = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted </div>';
                    
                    redirctHome($theMes,'back');

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