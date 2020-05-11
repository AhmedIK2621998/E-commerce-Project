<?php
     session_start();
     $pageTitle = 'Create New Item';
     include 'init.php';
     if (isset($_SESSION['user'])) {
        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $formErrors = array();

            $name       = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
            $desc       = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $price      = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
            $countery   = filter_var($_POST['countery'], FILTER_SANITIZE_STRING);
            $status     = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
            $category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
            $tags       = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

            if(strlen($name) < 4 ) {

                $formErrors[]  = 'Item Name Must Be At Least 4 Chracters';

            }
            if(strlen($desc) < 10 ) {

                $formErrors[]  = 'Item Description Must Be At Least 10 Chracters';
            
            }
            if(empty($price)) {

                $formErrors[]  = 'Item Price Must Be Not Empty';
            
            }
            if(strlen($countery) < 2) {

                $formErrors[]  = 'Item Country Must Be At Least 2 Chracters';
            
            }
            if(empty($status)) {

                $formErrors[]  = 'Item Status Must Be Not Empty';
                
            }
            if(empty($category)) {

                $formErrors[]  = 'Item Category Must Be Not Empty';
                
            }

            // // Check If Ther's No Proccesd The Update Operation لو كل الحاجات اللي فوق عدي منها 
                    
            if(empty($formError)) {
                            
                // Make Insert  For This Value In Datbase

                $stmt = $con->prepare("INSERT INTO 
                                            items(`Name`, `Description`, Price, Countery_Made, `Status`, Add_Date, Cat_ID, Member_ID, tags )
                                    VALUES(:zname, :zdesc, :zprice, :zcountery, :zstatus, now(), :zcat, :zmeber, :ztags) " );
                $stmt->execute(array(

                    'zname'         => $name, 
                    'zdesc'         => $desc, 
                    'zprice'        => $price, 
                    'zcountery'     => $countery, 
                    'zstatus'       => $status, 
                    'zcat'          => $category ,
                    'zmeber'        => $_SESSION['uid'],
                    'ztags'         => $tags

                ));

                    // Echo Success Message 

                if ( $stmt ) {

                    $succesMesg = 'Item Has Been Added';
                }                              
            
            }
    }
    
?>

<h1 class="text-center"><?php echo $pageTitle ?></h1>
<div class="create-ad block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo $pageTitle ?></div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        
                        <form class="form-horizontal main-form" action=<?php echo $_SERVER['PHP_SELF'] ?> method="POST">
                        <!-- Start Name Field  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-10 col-md-9">
                                    <input 
                                        pattern=".{4,}"
                                        title="This Fierld Is Required And At Least 4 Characters"
                                        type="text" 
                                        name="name"
                                        class="form-control live"  
                                        placeholder="Name Of The Item"
                                        data-class=".live-title"
                                        required />
                                </div>
                        </div>
                        <!-- End Name Field -->

                        <!-- Start Description Field  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-10 col-md-9">
                                    <input 
                                        pattern=".{10,}"
                                        title="This Fierld Is Required And At Least 10 Characters"
                                        type="text" 
                                        name="description"
                                        class="form-control live" 
                                        placeholder="Description Of The Item"
                                        data-class=".live-desc"
                                        required />
                                </div>
                        </div>
                        <!-- End Description Field -->

                        <!-- Start Price Field  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Price</label>
                                <div class="col-sm-10 col-md-9">
                                    <input 
                                        type="text" 
                                        name="price"
                                        class="form-control live" 
                                        placeholder="Price Of The Item"
                                        data-class=".live-price"
                                        required />
                                </div>
                        </div>
                        <!-- End Price Field -->
                        
                        <!-- Start Countery_Made Field  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Countery Of Made</label>
                                <div class="col-sm-10 col-md-9">
                                    <input 
                                        type="text" 
                                        name="countery"
                                        class="form-control" 
                                        placeholder="Countery Of Made"
                                        required />
                                </div>
                        </div>
                        <!-- End Countery_Made Field -->

                        <!-- Start Status Field  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-10 col-md-9">
                                    <select class="form-control" name="status" required >
                                        <option value="0">....</option>
                                        <option value="1">New</option>
                                        <option value="2">Like New</option>
                                        <option value="3">Used</option>
                                        <option value="4">Very Old</option>
                                    </select>
                                </div>
                        </div>
                        <!-- End Status Field -->
                        
                        <!-- To Make The Primary Key With Category And Items It Added -->
                        <!-- Start Category Field  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Category</label>
                                <div class="col-sm-10 col-md-9">
                                    <select class="form-control" name="category" required>
                                        <option value="">....</option>
                                        <?php
                                            $cats = getAllFrom('*','categories','','', 'ID');
                                            foreach ($cats as $cat) {
                                                echo "<option value='" . $cat['ID'] ."'>" . $cat['Name'] ."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <!-- End Category Field -->
                        <!-- Start The Tags Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-3 control-label">Tags</label>
                            <div class="col-sm-10 col-md-9">
                                <input 
                                    type="text"
                                    name="tags"
                                    class="form-control"
                                    placeholder="Separate tags with comma (,)" />
                            </div>
                        </div>
                        <!-- End The Tags Field -->
                        <!-- Start Submit button -->
                        <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="Add Item" class="btn btn-primary btn-2x">
                                </div>
                        </div>
                        <!-- End submit Field -->
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="thumbnail item-box live-preview">
                                <span class="price-tag">
                                    $<span class="live-price">0</span>
                                </span>
                                <img  class="img-responsive" src="ima.png" alt="" />
                                <div class="caption">
                                    <h3 class="live-title">Title</h3>
                                    <p class="live-desc">Description</p>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- Start The Through Error -->
                    <?php

                        if(! empty($formErrors)) {

                            foreach ($formErrors as $error) {

                                echo '<div class="alert alert-danger">' . $error . '</div>';
                            }
                        }
                        if (isset($succesMesg)) {
                            echo '<div class="alert alert-success">' . $succesMesg . '</div>';
                        }
                    ?>
                <!-- End The Through Error -->
            </div>
        </div>
    </div>
</div>

<?php
         
        } else {

            header('Location: login.php');

            exit();
        }
     include $tep . 'footer.php';  
     
?>