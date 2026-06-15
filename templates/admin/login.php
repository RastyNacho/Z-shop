
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../../assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/templatemo.css">
    <link rel="stylesheet" href="../../assets/css/custom.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">

    <!-- Load map styles -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

</head>
<?php
    require_once __DIR__ . '/../../app/core/Redirect.php';
    include __DIR__ . '/../../app/core/SQL_operation.php';

    session_start();
    $adminPage = new Redirect('home-admin.php');
    
    $canOpen = false;
    $database = new SQL_operation();    
    $data = $database->readAll('admins');

    $_SESSION['admin_logged_in'] = false;
    $_SESSION['admin_username'] = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $login = $_POST['login']?? '';
        $password = $_POST['password']?? '';
        
        if(empty($login)||empty($password)){
            $alertmessage = "Not all fields are filled!";
            echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
        }
        foreach($data as $row){
                if($row['login'] === $login && $row['passwords'] === $password){
                    $canOpen = true;
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_username'] = $username;
                break;
            }            
        } 
        if($_SESSION['admin_logged_in'] === true){$adminPage->redirect();} 
        else{
            $alertmessage = "Incorrect login or password!";
            echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
        }    
    } 
      
    
?>
<body>
   
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Login</label>
                        <input type="text" class="form-control mt-1" id="login" name="login" placeholder="Login">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Password</label>
                        <input type="password" class="form-control mt-1" id="password" name="password" placeholder="Password">
                    </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">Log as admin</button>
                    </div>
                </div>
            </form>
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="col text-end mt-2">
                    <button type="submit" name="back_to_shop" class="btn btn-success btn-lg px-3">Back to shop</button>
                </div>
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['back_to_shop'])) {
                    $homePage = new Redirect('../../index.php');
                    $homePage->redirect();
                } ?>
            </form>
        </div>
    </div>

    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="../assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/templatemo.js"></script>
    <script src="../assets/js/custom.js"></script>

</body>

</html>