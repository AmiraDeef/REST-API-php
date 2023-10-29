<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'phpRESTmyblog';
    private $username = 'root';
    private $password = '12345678';
    private $conn;
    //for db connection
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "connection error :" . $e->getMessage();
        }
        return $this->conn;
    }

    public function __construct()
    {
    }
}
