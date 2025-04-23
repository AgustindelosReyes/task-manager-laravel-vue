<div>
    <ul class="space-y-3 mt-4">
        @foreach ($tasks as $task)
            <!-- @include('components.task', ['task' => $task]) -->
            <x-task :task="$task" />
        @endforeach
    </ul>

</div>