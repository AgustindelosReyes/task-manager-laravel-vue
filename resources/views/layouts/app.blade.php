<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Manager')</title>
    @vite(['resources/css/app.css'])
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4">
        <h1 class="text-2xl font-bold">Task Manager</h1>
    </header>

    <main class="flex-1 p-4">
        @yield('content')
    </main>

    <footer class="bg-white shadow p-4 text-center">
        <p>&copy; {{ date('Y') }} Task Manager - Agustín</p>
    </footer>
    @vite(['resources/js/app.js'])
</body>
</html>
