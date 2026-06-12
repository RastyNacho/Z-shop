<?php
/*
    function redirect(string $url): void {
        header("Location: $url");
        exit();
    }
        */
    require('core/SQL_operation.php');
    function saveMessage(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $name = $_POST['name']?? '';
            $subject = $_POST['subject']?? '';
            $email = $_POST['email']?? '';
            $message = $_POST['message']?? '';

            if(empty($name)||empty($email)||empty($subject)||empty($message)){
                $alertmessage = "Not all fields are filled!";
                echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
                return;
            }

            if(!filter_var($email)){
                $alertmessage = "Incorrect email format!";
                echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
                return;
            }
            try{
                $operation = new SQL_operation();
                $operation->writeIntoSQL($name, $email, $subject, $message);
            }catch(Exception $e){echo '<script type="text/javascript">alert("'.$e.'")</script>';}


            $userinfo = "_____________" . PHP_EOL;
            $userinfo .= "Meno: $name" . PHP_EOL;
            $userinfo .= "Email: $email" . PHP_EOL;
            $userinfo .= "Predmet: $subject" . PHP_EOL;
            $userinfo .= "Sprava: $message" . PHP_EOL;

            file_put_contents('../app/contacts_history.txt', $userinfo, FILE_APPEND | LOCK_EX);
            $alertmessage = "Sprava bola ulozena";
            echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
        }
    }
    
?>