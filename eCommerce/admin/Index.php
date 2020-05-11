<?php
     session_start();
     $noNavbar = '';     // Navbar علشان مش هعمل شريط  
     $pageTitle = 'Login';
     if (isset($_SESSION['Username'])) {     ///  if user name register سابقا
        header('Location: dashboard.php');   // Redirct To Dashboard
     }
     
     include 'init.php';

     // Check If User Coming From HTTP Requset Method

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $username   = $_POST['user'];
        $password   = $_POST['pass'];
        $hashedpass = sha1($password);   // To Encrypt The Password 

        // Check If User Exists In Database

        $stmt = $con->prepare("SELECT
                                     UserID, UserName,`Password` 
                                FROM 
                                     users 
                                WHERE 
                                     UserName=?
                                AND 
                                     `Password`=? 
                                AND 
                                     GroupID=1
                                LIMIT 1");  //stmt ==> statment And GroupId Should be =1 Tobe Admin
        $stmt->execute(array($username, $hashedpass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        // IF Count > 0 This Mean The Database Conatin Record About This Username 

        if ( $count > 0) {
             $_SESSION['Username'] = $username;   // Register Session Name
             $_SESSION['ID'] = $row['UserID'];   // Register Session ID
             header('Location: dashboard.php');   // Redirct To Dashboard
             exit();
        }
    }

 ?>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h3 class="text-center"> Admin Login</h3>
        <input class="form-control" type="text" name="user" placeholder="Enter User Name" autocomplet="off" />
        <input class="form-control" type="password" name="pass" placeholder="Enter Password" autocomplet="new-password" />
        <input class="btn btn-primary btn-block" type="submit" value="Login" />
    </form>
<?php 
     include $tep . 'footer.php';  
 ?>