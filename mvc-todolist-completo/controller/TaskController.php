<?php
header('Content-Type: application/json');

require_once '../model/Task.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=todo_app', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $taskModel = new Task($pdo);
    $response = ['status' => 'error', 'message' => 'Unknown action'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'add' && !empty(trim($_POST['description']))) {
            $description = htmlspecialchars(trim($_POST['description']));
            $taskModel->addTask($description);
            $response = ['status' => 'success', 'message' => 'Task added'];
        } elseif ($action === 'delete' && isset($_POST['id'])) {
            $taskModel->deleteTask((int)$_POST['id']);
            $response = ['status' => 'success', 'message' => 'Task deleted'];
        } elseif ($action === 'complete' && isset($_POST['id'])) {
            $taskModel->completeTask((int)$_POST['id']);
            $response = ['status' => 'success', 'message' => 'Task completed'];
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'getTasks') {
        $pendingTasks = $taskModel->getAllTasks('pending');
        $completedTasks = $taskModel->getAllTasks('completed');
        $response = [
            'status' => 'success',
            'pendingTasks' => $pendingTasks,
            'completedTasks' => $completedTasks
        ];
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}
