<?php

require_once 'db.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addUser($username, $email, $password) {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->connect()->prepare($sql);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $passwordHash
        ]);
        return $stmt->rowCount();
    }

    public function checkUser($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }
        return false; 
    }
}
