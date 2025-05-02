<div >
    <ul id="taskList" class="space-y-4 max-w-full overflow-x-auto">
        @foreach ($tasks as $task)
            <x-task :task="$task" />
        @endforeach
    </ul>

</div>