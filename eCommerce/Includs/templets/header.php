<!DOCTYPE html>
<html>
    <header>
        <meta charset="UTF-8">
        <title><?php gettitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css?>bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $css?>font-awesome.min.css"/>
        <link rel="stylesheet" href="<?php echo $css?>front_end.css" />
    </header>
    <body>
    <div class="upper-bar">
        <div class="container">
          <?php
               if (isset($_SESSION['user'])) {   ?> 

                <img class="my-image img-thumbnail img-circle" src="ima.png" alt="">
                <div class="btn-group my-info">
                    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <?php echo $sessionUser ?>
                        <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="Profile.php">My Profiel</a></li>
                        <li><a href="newad.php">New Item</a></li>
                        <li><a href="Profile.php#my-ads">My Items</a></li>
                        <li><a href="logout.php">Logout </a></li>
                    </ul>
                </div>

                <?php

               } else {
          ?>
            <a href="login.php">
                <span class="pull-right">Login/Signup</span>
            </a>
            <?php } ?>
        </div>
    </div>
    <nav class="navbar navbar-inverse">
    <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="Index.php">HomePage</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav navbar-right">
      <?php
            $allCats = getAllFrom("*", "categories", "Where parent = 0", "", "ID" , "ASC");
            foreach ($allCats as $cat) {

                echo '<li>
                        <a href="categories.php?pageid=' . $cat['ID'] . '">
                            ' .$cat['Name'] . '
                        </a>
                      </li>';

            }
      ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>