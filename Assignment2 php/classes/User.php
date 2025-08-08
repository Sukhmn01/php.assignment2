<?php
class User {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password, $image) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        if ($stmt->fetch()) return false;

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, image) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hash, $image]);
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) return $user;
        return false;
    }
}

