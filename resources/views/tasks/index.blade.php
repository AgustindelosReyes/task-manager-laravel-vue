<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/styles.css" rel="stylesheet">

    <title>Tareas</title>
</head>
<body>
    <h1>Lista de Tareas</h1>
    
    <ul>
        @foreach ($tasks as $task)
            <li>{{ $task->name }} - {{ $task->description }} - 
                @if ($task->completed) 
                    Completada
                @else
                    Pendiente
                @endif
            </li>
        @endforeach
    </ul>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <label for="name">Nombre de la tarea:</label>
        <input type="text" name="name" required>
        <label for="description">Descripción:</label>
        <textarea name="description" required></textarea>
        <label for="completed">Completada:</label>
        <input type="checkbox" name="completed">
        <button type="submit">Guardar</button>
    </form>
</body>
</html>
