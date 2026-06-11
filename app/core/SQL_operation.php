<?php
require_once('../config/Database.php');
class SQL_operation
{
    private Database $database;
    private PDO $connection;
    public function __construct()
    {
        $this->database = new Database();
        $this->connection = $this->database->getConnection();
    }

    public function writeIntoSQL($name, $email, $subject, $message){
        try{
            if(!(empty($name)||empty($email)||empty($subject))){
                
                //$connection = $this->database->getConnection();

                $sql = "INSERT INTO posts(name, email, subject, message) VALUES (:name, :email, :subject, :message)";
                $command = $this->connection->prepare($sql);
                $command->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);

                
                $sql = "INSERT INTO users(name, email) VALUES (:name, :email)";
                $command = $this->connection->prepare($sql);
                $command->execute(['name' => $name, 'email' => $email]);

                
            }
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
    }
    public function readAll()
    {
        if(!(empty($tablename))){
            $sql = "SELECT * From :tablesname";
            $command = $this->connection->prepare($sql);
            $command->execute(['tablename' => $tablename]);

            $data = $command->fetchAll(PDO::FETCH_ASSOC);
            foreach($data as $row){echo $data;}
        }
    }
    public function readFromSQL_user() : ?array{
        try{
            
                

            $sql = "select * From users ;";
            $command = $this->connection->query($sql);
            $user = $command->fetchAll(PDO::FETCH_ASSOC);
            foreach($user as $row){echo "Name: " . $user['name'] . " - Email: " . $user['email'] . "<br>";}
            return $user;
                
            
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
        return null;
    }
    public function readFromSQL_post() : ?array{
        try{
           
            $sql = "select * From posts ;";
            $command = $this->connection->query($sql);
            $post = $command->fetchAll(PDO::FETCH_ASSOC);
            foreach($post as $row){echo "Name: " . $post['name'] . " - Email: " . $post['email'] . " - Subject: " . $post['subject'] ." - Message: " . $post['message'] ."<br>";}
            return $post;
                
            
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
        return null;
    }
    public function updateSQL($table, $who, $what, $value) : void{

        try{
            if($what == 'email'){echo '<script type="text/javascript">Alert("Email can not be updated");</script>';throw new Exception("Tried to change email");}
            $sql = "UPDATE :tablename SET :what = :val WHERE email = :who ;";
            $command = $this->connection->prepare($sql);
            $command->execute(['tablename' => $table, 'who'=> $who,'what'=> $what,'val'=> $value]);

            echo "Number of updated rows". $command->rowCount() ."<br>";
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
    }
    public function deleteSQL($table, $who) : void{
        $sql = "DELETE FROM :tablename WHERE email = :who ;";
        $command = $this->connection->prepare($sql);
        $command->execute(["tablename"=> $table,"who"=> $who]);

        echo "Number of updated rows". $command->rowCount() ."<br>";
    }
}