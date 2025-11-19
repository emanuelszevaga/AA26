document.addEventListener('DOMContentLoaded', loadTasks);

document.getElementById('taskForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const description = document.getElementById('taskDescription').value.trim();
    if (description) {
        addTask(description);
        document.getElementById('taskDescription').value = ''; // Clear the input
    }
});

// Función para cargar las tareas inicialmente
function loadTasks() {
    fetch('controller/TaskController.php?action=getTasks')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                renderTasks(data.pendingTasks, data.completedTasks);
            }
        });
}

// Función para renderizar las listas de tareas
function renderTasks(pendingTasks, completedTasks) {
    const taskList = document.getElementById('taskList');
    const completedTaskList = document.getElementById('completedTaskList');
    taskList.innerHTML = '';
    completedTaskList.innerHTML = '';

    pendingTasks.forEach(task => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${task.description}
            <button onclick="completeTask(${task.id})">Completar</button>
            <button onclick="deleteTask(${task.id})">Eliminar</button>
        `;
        taskList.appendChild(li);
    });

    completedTasks.forEach(task => {
        const li = document.createElement('li');
        li.textContent = `${task.description} - Completado el: ${task.completed_at}`;
        completedTaskList.appendChild(li);
    });
}

// Función para agregar una nueva tarea
function addTask(description) {
    fetch('controller/TaskController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add&description=${encodeURIComponent(description)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadTasks(); // Recargar las tareas desde el servidor
        }
    });
}

// Función para marcar una tarea como completada
function completeTask(id) {
    fetch('controller/TaskController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=complete&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadTasks(); // Recargar las tareas desde el servidor
        }
    });
}

// Función para eliminar una tarea
function deleteTask(id) {
    fetch('controller/TaskController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=delete&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadTasks(); // Recargar las tareas desde el servidor
        }
    });
}
