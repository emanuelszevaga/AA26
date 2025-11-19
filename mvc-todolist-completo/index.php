<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="view/style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Tareas</h1>
        
        <form id="taskForm">
            <input type="text" id="taskDescription" placeholder="Nueva tarea" required>
            <button type="submit">Agregar</button>
        </form>

        <h2>Tareas Pendientes</h2>
        <ul id="taskList"></ul>

        <h2>Tareas Completadas</h2>
        <ul id="completedTaskList"></ul>
    </div>

    <script src="view/script.js"></script>
</body>
</html>
