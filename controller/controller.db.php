<?php

date_default_timezone_set("Asia/Manila");
date_default_timezone_get();

class db_conn_mysql{

    private $servername;
    private $username;
    private $password;
    private $db;

    protected function connect_mysql() {

        $this->servername = "192.168.101.88:3324";
        $this->username = "root";
        $this->password = "moy";
        $this->db = "hris";
        try {

        $conn = new PDO("mysql:host=$this->servername; dbname=$this->db", $this->username, $this->password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully"; 
        }
        catch(PDOException $e)
        {
        //echo "Connection failed: " . $e->getMessage();
        }

       return $conn;
    }
}
?>