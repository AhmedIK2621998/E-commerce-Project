<?php  include 'init.php'; ?>

<div class="container">
    <div class="row">
        <?php
            if(isset($_GET['name'])) {
                $tag = $_GET['name'];
                echo "<h1 class='text-center'>" . $tag . "</h1>";
                $tagItems = getAllFrom("*", "items", "Where tags like '%$tag%'", "And Approve = 1", "Item_ID");
                foreach ($tagItems  as $tag) {
                    echo '<div class="col-sm-6 col-md-3">';
                        echo '<div class="thumbnail item-box">';
                            echo '<span class="price-tag">' . $tag['Price'] .'</span>';
                            echo '<img  class="img-responsive" src="ima.png" alt="" />';
                            echo '<div class="caption">';
                                echo '<h3><a href="Item.php?itemid='. $tag['Item_ID'] .'">' . $tag['Name'] . '</a></h3>';
                                echo '<p>' . $tag['Description'] . '</p>';
                                echo '<div class="date">' . $tag['Add_Date'] . '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                } 
            } else {

                echo '<div class="alert alert-danger">You Must Add Page ID </div>';

        }
            
        ?>
    </div>
</div>

<?php include $tep . 'footer.php'; ?>