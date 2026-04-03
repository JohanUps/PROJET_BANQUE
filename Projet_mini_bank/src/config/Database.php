<?php
class Database {
    private $host = "db";
    private $db_name = "minibank";
    private $username = "root";
    private $password = "root";
    public $conn;

    public function getConnection(){

        $tries = 5;

        while($tries > 0){
            try{
                return new PDO(
                    "mysql:host=db;dbname=minibank;charset=utf8mb4",
                    "root",
                    "root",
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch(PDOException $e){
                $tries--;
                sleep(1);
            }
        }
        return null;
    }
}
