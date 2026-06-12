
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
    include __DIR__ .'/../../app/core/SQL_operation.php';
    $SQL = new SQL_operation() ;
    $posts = $SQL->readAll('posts');
    $users = $SQL->readAll('users');
    ?>
    <!-- Close Header -->

    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Posts:</label>
                        <table>
                          <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Mail</th>
                            <th>Subject</th>
                            <th>Message</th>
                          </tr>
                          <?php 

                            foreach ($posts as $post) { 
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                                    <td><?php echo htmlspecialchars($post['name']); ?></td>
                                    <td><?php echo htmlspecialchars($post['email']); ?></td>
                                    <td><?php echo htmlspecialchars($post['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($post['message']); ?></td>
                                </tr>
                            <?php 
                            } 
                            ?>
                        </table>                           
                    
                        <label for="inputemail">Users:</label>
                        <table>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                          </tr>
                          <?php 
                            foreach ($users as $user) { 
                          ?>
                            <tr>
                              <td><?php echo htmlspecialchars($user['name']); ?></td>
                              <td><?php echo htmlspecialchars($user['email']); ?></td>
                            </tr>
                          <?php 
                            } 
                          ?>
                        </table>
                        <label for="inputemail">Edit Post:</label><br>
                        <form action="" method="POST">
                            <?php

                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update'])) {

                                    $who   = trim($_POST['post_id']);
                                    $what  = trim($_POST['column_name']);
                                    $value = trim($_POST['new_value']);


                                    $dbOperation = new SQL_operation(); 
                                    $dbOperation->updateSQL($who, $what, $value);
                                }
                            ?>
                            <label for="inputemail">ID:</label>
                            <input type="text" class="form-control mt-1" id="id" name="post_id" placeholder="ID">
                            <label for="inputemail">Edit collumn:</label>
                            <input type="text" class="form-control mt-1" id="editCollumn" name="column_name" placeholder="Collumn">
                            <label for="inputemail">Value:</label>
                            <input type="text" class="form-control mt-1" id="value" name="new_value" placeholder="Value">
                            <div class="col text-end mt-2">
                                <button type="submit" class="btn btn-success btn-lg px-3">Edit</button>
                            </div>
                        </form>
                        <label for="inputemail">Delete Post:</label>
                        <?php

                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_update'])) {

                                    $who  = trim($_POST['delete_id']);

                                    if(!empty($who)){
                                        $dbOperation = new SQL_operation(); 
                                        $dbOperation->deletePost($who);
                                    }
                                }
                            ?>
                        <form action="" method="POST">
                            <label for="inputemail">ID:</label>
                            <input type="text" class="form-control mt-1" id="id" name="delete_id" placeholder="ID">
                            <div class="col text-end mt-2">
                                <button type="submit" class="btn btn-success btn-lg px-3">Delete</button>
                            </div>
                        </form>
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