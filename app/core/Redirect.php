<?php
include __DIR__ . '/../../app/core/SQL_operation.php';
class Redirect
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function redirect(): void
    {
        header('Location: ' . $this->url);
        exit;
    }
    
    public function redirectAdmin():void
    {  
        //$this->redirect();
        $canOpen = false;
        $database = new SQL_operation();    
        $data = $database->readAll('admins');

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $login = $_POST['login']?? '';
            $password = $_POST['password']?? '';
            
            if(empty($login)||empty($password)){
                $alertmessage = "Not all fields are filled!";
                echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
                return;
            }
            foreach($data as $row){
            if($row['login'] === $login && $row['passwords'] === $password){
                $canOpen = true;
                break;
            }            
        }
        }    
        if($canOpen){$this->redirect();} 
        else{
            $alertmessage = "Incorrect login or password!";
            echo '<script type="text/javascript">alert("'.$alertmessage.'")</script>';
        }
    }
}