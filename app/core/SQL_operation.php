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
        if(!(empty($name)||empty($email)||empty($subject))){
            
            $sql = "INSERT INTO posts(name, email, subject, message) VALUES (:name, :email, :subject, :message)";
            $command = $this->connection->prepare($sql);
            $command->execute(['name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message]);
            
            $sql = "INSERT INTO users(name, email) VALUES (:name, :email)";
            $command = $this->connection->prepare($sql);
            $command->execute(['name' => $name, 'email' => $email]);
            
        }
    }
    public function readAll($tablename) : ?array
    {
        if(!(empty($tablename))){
            $sql = "SELECT * From $tablename";
            $command = $this->connection->prepare($sql);
            $command->execute();

            $data = $command->fetchAll(PDO::FETCH_ASSOC);
            $lines = json_encode($data);
            return $data;
        }
        return null;
    }
    public function updateSQL($id, $name, $subject, $message) : void{
         
        $sql = "UPDATE posts SET name = :name, subject = :subject, message = :message WHERE id = :id";
        $command = $this->connection->prepare($sql);
        $command->execute(['id'=> $id, 'name'=> $name,'subject'=> $subject, 'message'=> $message]);
    }
    public function deletePost($id) : void{
        $sql = "DELETE FROM posts WHERE id = :id ";
        $command = $this->connection->prepare($sql);
        $command->execute(["id"=> $id]);
    }
    public function deleteUSer($email) : void{
        $sql = "DELETE FROM users WHERE email = :email; DELETE FROM posts WHERE email = :email";
        $command = $this->connection->prepare($sql);
        $command->execute(["email"=> $email]);
    }
}