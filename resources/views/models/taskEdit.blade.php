<x-app-layout>
    <x-slot:title>
		{{ __('Task') }}:{{ $task->name }}
	</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight overflow-hidden px-2 border-b-2 {{ str_replace('bg','border', $task->color->base) }}">
            {{ $task->name }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-xl sm:rounded-lg">
                <div class="bg-white relative overflow-x-auto shadow-md sm:rounded-lg px-4 py-4 border-2 {{ str_replace('bg','border', $task->color->base) }}">
                    <livewire:pages.tasks.edit :$task :$editable />
                    <div class="bg-white sm:grid sm:grid-cols-3">
                        <div class="row-span-2 border p-2 bg-neutral-200">
                            <livewire:pages.tasks.edit-content :$task />
                        </div>
                        @can('note.view')
                        <div class="min-h-40 border relative">
                            <livewire:pages.modules.notes type="tasks" :item="$task->id" />
                        </div>
                        @endcan
                        <div class="min-h-40 border p-2">Events</div>
                        @can('file.view')
                        <div class="min-h-40 border relative">
                            <livewire:pages.modules.files type="tasks" :item="$task->id" />
                        </div>
                        @endcan
                        <div class="min-h-40 border p-2">
                            <p>Статистика (на подумать)...</p>
                            <p>Процесс выполнения ???</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

