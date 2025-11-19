<?php
class Task {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Solución: Usar 0 (pendiente) o 1 (completada) en lugar de strings
    public function getAllTasks($status = 0) {
        $stmt = $this->pdo->prepare("SELECT * FROM tareas WHERE completada = ? ORDER BY id DESC");
        $stmt->execute([$status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Solución: Usar 0 (pendiente) o 1 (completada) en lugar de strings
    public function addTask($description, $status = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO tareas (descripcion, completada) VALUES (?,?)");
        return $stmt->execute([$description, $status]);
    }

    public function deleteTask($id) {
        $stmt = $this->pdo->prepare("DELETE FROM tareas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Solución: Usar 1 (entero) en lugar de string 'completed'
    public function completeTask($id) {
        $stmt = $this->pdo->prepare("UPDATE tareas SET completada = 1, completed_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
