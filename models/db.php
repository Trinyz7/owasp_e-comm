<?php

class Database
{

    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;


    public function __construct()
    {
        $config = parse_ini_file('../config.ini', true);

        $this->host = $config['database']['host'];
        $this->port = $config['database']['port'];
        $this->db_name = $config['database']['dbname'];
        $this->username = $config['database']['username'];
        $this->password = $config['database']['password'];
    }
    public function connect()
    {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name,
                    $this->username,
                    $this->password
                );
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
        return $this->conn;
    }

    public function query($sql)
    {
        $this->connect(); 
        return $this->conn->query($sql);
    }
}