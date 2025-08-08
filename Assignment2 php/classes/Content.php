<?php
class Content {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($userId, $title, $desc, $image) {
        $stmt = $this->conn->prepare("INSERT INTO content (user_id, title, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $title, $desc, $image]);
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM content ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM content WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $desc, $image) {
        $stmt = $this->conn->prepare("UPDATE content SET title = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$title, $desc, $image, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM content WHERE id = ?");
        $stmt->execute([$id]);
    }
}

