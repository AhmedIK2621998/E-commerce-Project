<?php
     ob_start();
     session_start();
     $pageTitle = 'Login';
     if (isset($_SESSION['user'])) {     //  if user register سابقا
        header('Location: Index.php');   // Redirct To Dashboard
     }
     
    include 'init.php'; 

     // Check If User Coming From HTTP Requset Method

     if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_POST['login'])) {
          
            $user   = $_POST['username'];
            $pass   = $_POST['password'];
            $hashedpass = sha1($pass);   // To Encrypt The Password 

            // Check If User Exists In Database

            $stmt = $con->prepare("SELECT
                                        UserID, UserName, `Password` 
                                    FROM 
                                        users 
                                    WHERE 
                                        UserName=?
                                    AND 
                                        `Password`=?");  
            
            
            $stmt->execute(array($user, $hashedpass));

            $get = $stmt->fetch();

            $count = $stmt->rowCount();

            // IF Count > 0 This Mean The Database Conatin Record About This Username 

            if ( $count > 0) {

                $_SESSION['user'] = $user;   // Register Session Name

                $_SESSION['uid'] = $get['UserID'];
                
                header('Location: Index.php');   // Redirct To Dashboard
                exit();
            }
        } else {

            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            $email      = $_POST['Email'];

            $formErrors = array();
            
            if(isset($username)) {

                $filtredUser = filter_var($username, FILTER_SANITIZE_STRING);
                
                if(strlen($filtredUser) < 4) {

                    $formErrors[] = 'Username Must Be Larger Than 4 Characters';
                }
            }

            if(isset($password) && isset($password2)) {

                if(empty($password)) {

                    $formErrors[] = 'Password Can\'t be Empty';

                }

                if(sha1($password) !== sha1($password2)) {

                    $formErrors[] = 'Sorry The Password Is Not Match';

                }
            }

            if(isset($email)) {

                $filtredEmail = filter_var($email , FILTER_SANITIZE_EMAIL);

                if ( filter_var($filtredEmail,FILTER_VALIDATE_EMAIL) !=true ) {

                    $formErrors[] = 'This Email Is Not Valid';

                }
            }

            //Check If Ther's No Proccesd The user Add لو كل الحاجات اللي فوق عدي منها 
                    
            if(empty($formError)) {

                // Check If The User  Exists In Data Base

                $check = CheckItem("UserName","users",$username);

                if ($check == 1) {

                    $formErrors[] = 'Sorry This User Exist In Database';

                } else {
                   
                    // Make Insert  For This Value In Datbase

                    $stmt = $con->prepare("INSERT INTO 
                                            users(UserName, `Password`, Email, RegStatus, Date )
                                        VALUES(:zuser, :zpass, :zmail,0, now())");
                    $stmt->execute(array(

                        'zuser'   => $username, 
                        'zpass'   => sha1($password), 
                        'zmail'   => $email, 
                    ));

                    // Echo Success Message 

                    $succesMesg = 'Congrats You Are Registerd Now';
                              
                    }
                }


        }
    }

?>
    <div class="container login-page">
        <h1 class="text-center">
            <span class="selected" data-class="login">Login</span> | 
            <span data-class="signup">Signup</span>
        </h1>
        <!-- Start The Login Form -->
        <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="input-container">
                <input 
                    class="form-control" 
                    type="text" 
                    name="username" 
                    autocomplete="off" 
                    placeholder="Type Your Username"
                    required />
            </div>
            <div class="input-container">
                <input 
                    class="form-control" 
                    type="password" 
                    name="password" 
                    autocomplete="new password"
                    placeholder="Type Your Password"
                    required />
            </div>
            <input class="btn btn-primary btn-block" name="login" type="submit" value="Login">
        </form>
        <!-- End The Login Form -->

        <!-- Start The Signup Form -->
        <form class="signup" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="input-container">
                <input 
                   pattern = ".{4,}"
                   title = "Username Must Be 4 chars"
                    class="form-control" 
                    type="text" 
                    name="username" 
                    autocomplete="off" 
                    placeholder="Type Your Username"
                    required />
            </div>
            <div class="input-container">
                <input 
                    minlength = "4"
                    class="form-control" 
                    type="password" 
                    name="password" 
                    autocomplete="new password"
                    placeholder="Type Your Complex Password"
                    required />
            </div>
            <div class="input-container">
                <input 
                    minlength = "4"
                    class="form-control" 
                    type="password" 
                    name="password2"
                    autocomplete="new password" 
                    placeholder="Confirm the password again"
                    required />
            </div>
            <div class="input-container">
                <input 
                    class="form-control" 
                    type="email" 
                    name="Email" 
                    placeholder="Type The Email" />
            </div>
            <input class="btn btn-success btn-block" name="signup" type="submit" value="Login">
        </form>
        <!-- End The Signup Form -->
        <div class="the-errors text-center">
        <?php 
            if(! empty($formErrors)) {

                foreach($formErrors as $error) {

                    echo '<div class="msg error">' . $error . '</div>';
                }
            }

            if (isset($succesMesg)) {
                
                echo '<div class="msg success">' . $succesMesg . '</div>';

            }
        ?>
        </div>
    </div>
<?php 
    include $tep . 'footer.php'; 
    ob_end_flush();
?>