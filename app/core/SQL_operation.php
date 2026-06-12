<?php
require_once __DIR__ . '/../../config/Database.php';
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
                

                $sql = "INSERT INTO posts(name, email, subject, message) VALUES (:name, :email, :subject, :message)";
                $command = $this->connection->prepare($sql);
                $command->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);

                
                $sql = "INSERT INTO users(name, email) VALUES (:name, :email)";
                $command = $this->connection->prepare($sql);
                $command->execute(['name' => $name, 'email' => $email]);

                
            }
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
    }
    public function readAll($tablename) : ?array
    {
        if(!(empty($tablename))){
            $sql = "SELECT * From $tablename";
            $command = $this->connection->prepare($sql);
            $command->execute();

            $data = $command->fetchAll(PDO::FETCH_ASSOC);
            $lines = json_encode($data);
            //echo ''.$lines.'';
            //foreach($data as $row){echo $data;}
            return $data;
        }
        return null;
    }
    public function readFromSQL_user() : ?array{
        try{
            
                

            $sql = "select * From users ;";
            $command = $this->connection->query($sql);
            $user = $command->fetchAll(PDO::FETCH_ASSOC);
            //foreach($user as $row){echo "Name: " . $user['name'] . " - Email: " . $user['email'] . "<br>";}
            return $user;
                
            
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
        return null;
    }
    public function readFromSQL_post() : ?array{
        try{
           
            $sql = "select * From posts ;";
            $command = $this->connection->query($sql);
            $post = $command->fetchAll(PDO::FETCH_ASSOC);
            foreach($post as $row){echo "ID: " . $post['id'] ." - Name: " . $post['name'] . " - Email: " . $post['email'] . " - Subject: " . $post['subject'] ." - Message: " . $post['message'] ."<br>";}
            return $post;
                
            
        }catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
        return null;
    }
    public function updateSQL($who, $what, $value) : void{

        try{
            
            if(strtolower($what) == 'email'){echo '<script type="text/javascript">Alert("Email can not be updated");</script>';throw new Exception("Tried to change email");}
            $sql = "UPDATE posts SET $what= :val WHERE id = :who ;";
            $command = $this->connection->prepare($sql);
            $command->execute(['who'=> $who,'val'=> $value]);
            echo "Number of updated rows". $command->rowCount() ."<br>";

        }
        catch(PDOException $e){echo '<script type="text/javascript">console.log("'.$e.'");</script>';}
    }
    public function deletePost($id) : void{
        $sql = "DELETE FROM posts WHERE id = :id ";
        $command = $this->connection->prepare($sql);
        $command->execute(["id"=> $id]);

        //echo "Number of updated rows ". $command->rowCount() ."<br>";
    }
}