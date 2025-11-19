<?php
class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllTasks($status = 'pending') {
        $stmt = $this->pdo->prepare("SELECT * FROM tareas WHERE completada = ? ORDER BY id DESC");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTask($description, $status = 'pending') {
        $stmt = $this->pdo->prepare("INSERT INTO tareas (descripcion, completada) VALUES (?,?)");
        return $stmt->execute([$description, $status]);
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tareas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function completeTask($id) {
        $stmt = $this->pdo->prepare("UPDATE tareas SET completada = 'completed', completed_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
