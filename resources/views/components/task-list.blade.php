<div>
    <ul class="space-y-4 max-w-full overflow-x-auto">
        @foreach ($tasks as $task)
            <!-- @include('components.task', ['task' => $task]) -->
            <x-task :task="$task" />
        @endforeach
    </ul>

</div>