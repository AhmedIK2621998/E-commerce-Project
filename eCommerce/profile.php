<?php
     session_start();
     $pageTitle = 'Profile';
     include 'init.php';
     if (isset($_SESSION['user'])) {

        $getUser = $con->prepare("SELECT * FROM users WHERE Username=?");

        $getUser->execute(array($sessionUser));

        $info = $getUser->fetch();
        $userinfo = $info['UserID'];

?>

<h1 class="text-center">My Profile</h1>
<div class="infromation block">
    <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">My Infromation</div>
        <div class="panel-body">
            <ul class="list-unstyled">
                <li> 
                    <i class="fa fa-unlock-alt fa-fw"></i>
                    <span>Login Name</span> : <?php echo $info['UserName']  ?>
                </li>
                <li> 
                    <i class="fa fa-envelope-o fa-fw"></i>
                    <span>Email</span> : <?php echo $info['Email']  ?>
                </li>
                <li> 
                    <i class="fa fa-user fa-fw"></i>
                    <span>Full Name</span> : <?php echo $info['FullName']  ?>
                </li>
                <li> 
                    <i class="fa fa-calendar fa-fw"></i>
                    <span>Register Date</span> : <?php echo $info['Date']  ?>
                </li>
                <li> 
                    <i class="fa fa-tags fa-fw"></i>
                    <span>Favourite Category</span> :
                </li>
            </ul>
        </div>
    </div>
    </div>
</div>

<div id="my-ads" class="My-ads block">
    <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">My Items</div>
        <div class="panel-body">
            <?php
                $myItems = getAllFrom("*", "items", "Where Member_ID = $userinfo", "", "Item_ID");
                if (! empty($myItems)) {
                        echo '<div class="row">';
                        foreach ($myItems  as $item) {
                            echo '<div class="col-sm-6 col-md-3">';
                                echo '<div class="thumbnail item-box">';
                                    if($item['Approve'] == 0) { 

                                        echo '<span class="approve-status">Waiting Approval</span>';

                                    }
                                    echo '<span class="price-tag">$' . $item['Price'] . '</span>';
                                    echo '<img  class="img-responsive" src="ima.png" alt="" />';
                                    echo '<div class="caption">';
                                        echo '<h3><a href="Item.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] . '</a></h3>';
                                        echo '<p>' . $item['Description'] . '</p>';
                                        echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                    }
                    echo '</div>';
                } else {

                    echo 'There\'s No Comments To Show Here , Create <a href="newad.php">New Ad</a>';

                }
            ?>
        </div>
    </div>
    </div>
</div>

<div class="infromation block">
    <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Latest Comments</div>
        <div class="panel-body">
        <?php
            $mycomment = getAllFrom("comment", "comments", "Where user_id = {$userinfo}", "", "c_id");

            if (! empty($mycomment)) {

                foreach ($mycomment as $comm) {
                    
                    echo '<p>' . $comm['comment'] . '</p>';
                }
                
            } else {

                echo 'Ther\'s No Comments To Show From Database';
            }
        ?>
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