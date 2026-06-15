
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Interface</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="../../assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">

    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/templatemo.css">
    <link rel="stylesheet" href="../../assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="../../assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../assets/css/admin_interface.css">
<!--
    
TemplateMo 559 Zay Shop

https://templatemo.com/tm-559-zay-shop

-->
</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@company.com">info@company.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:010-020-0340">010-020-0340</a>
                </div>
                <div>
                    <a class="text-light" href="https://fb.com/templatemo" target="_blank" rel="sponsored"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://twitter.com/" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                    <a class="text-light" href="https://www.linkedin.com/" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->


    <!-- Header -->
    <?php
    include '../partials/header-admin.php';
    include_once __DIR__ .'/../../app/core/SQL_operation.php';
    $SQL = new SQL_operation() ;
    $posts = $SQL->readAll('posts');
    $users = $SQL->readAll('users');
    ?>
    <!-- Close Header -->

    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-8 mb-5">
                        <label for="inputname">Posts:</label>
                        <table>
                          <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Mail</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Edit</th>
                            <th>Delete</th>
                          </tr>
                          <?php  
                            //require_once __DIR__ .'/../../app/core/SQL_postsTabObject.php';                           
                            foreach ($posts as $post) { 
                            ?>
                                <tr>
                                    <td><?php $ID = $post['id']; echo htmlspecialchars($ID);?></td>
                                    <td><?php $NAME = $post['name']; echo htmlspecialchars($NAME); ?></td>
                                    <td><?php $EMAIL = $post['email']; echo htmlspecialchars($EMAIL); ?></td>
                                    <td><?php $SUBJECT = $post['subject']; echo htmlspecialchars($SUBJECT); ?></td>
                                    <td><?php $MESSAGE = $post['message']; echo htmlspecialchars($MESSAGE); ?></td>
                                    <td style="">
                                        <form action="" method="POST">
                                            <button type="submit" name="tab_update" style="background-color: #59ab6e;">Update</button>
                                            <input type="hidden" name="post_id_edit" value="<?php echo $ID; ?>">
                                            <div id="edit_form" style="display: block;">
                                                
                                                <label for="inputemail">Name:</label>
                                                <input type="text" class="form-control mt-1" id="change_name" name="change_name" value="<?php echo $NAME; ?>" placeholder="Name">
                                                <label for="inputemail">Subject:</label>
                                                <input type="text" class="form-control mt-1" id="change_subject" name="change_subject" value="<?php echo $SUBJECT; ?>" placeholder="Subject">
                                                <label for="inputemail">Message:</label>
                                                <input type="text" class="form-control mt-1" id="change_message" name="change_message" value="<?php echo $MESSAGE;/*prec*/  ?>" placeholder="Message">
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="post_id" value="<?php echo $ID; ?>">
                                            <button type="submit" name="tab_delete" style="background-color: #59ab6e;">Delete</button>            
                                        </form>
                                    </td>                              
                                </tr>
                            <?php 
                            } 
                            
                            if (isset($_POST['tab_delete'])) {
                                try {
                                    $id = (int)$_POST['post_id'];
                                    $dbOperation = new SQL_operation();
                                    $dbOperation->deletePost($id);
                                }
                                catch (Exception $e) {
                                    echo '<script>console.log('.$e->getMessage().');</script>';
                                }
                            } 
                            if(isset($_POST['tab_update']) && $_SERVER['REQUEST_METHOD'] === 'POST'){

                                $id = (int)$_POST['post_id_edit'];
                                $name  = trim($_POST['change_name']);
                                $Subject = trim($_POST['change_subject']);
                                $Message = trim($_POST['change_message']);

                                $dbOperation = new SQL_operation(); 
                                $dbOperation->updateSQL($id, $name, $Subject, $Message);
                                
                            }                                                      
                            ?>
                        </table>                           
                    
                        <label for="inputemail">Users:</label>
                        <table>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Delete</th>
                          </tr>
                          <?php 
                            foreach ($users as $user) { 
                          ?>
                            <tr>
                              <td><?php echo htmlspecialchars($user['name']); ?></td>
                              <td><?php echo htmlspecialchars($user['email']); ?></td>
                              <td>
                                <form method="post" style="display: inline;">
                                  <input type="hidden" name="user_id" value="<?php echo $user['email']; ?>">
                                  <button type="submit" name="user_delete" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer;">Delete</button>
                                </form>
                              </td>
                            </tr>
                          <?php 
                            }
                            if (isset($_POST['user_delete'])) {
                                try {
                                    $email = $_POST['user_id'];
                                    $dbOperation = new SQL_operation();
                                    $dbOperation->deleteUSer($email);
                                }
                                catch (Exception $e) {
                                    echo '<script>console.log('.$e->getMessage().');</script>';
                                }
                            }  
                          ?>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php
    include '../partials/footer.php';
        ?>
    <!-- End Footer -->

    <!-- Start Script -->
    <script src="../assets/js/jquery-1.11.0.min.js"></script>
    <script src="../assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/templatemo.js"></script>
    <script src="../assets/js/custom.js"></script>
    <!-- End Script -->
</body>

</html>