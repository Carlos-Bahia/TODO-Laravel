<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Criar Tarefas') }}
            </h2>

            <h3 class="font-semibold text-x text-gray-800 dark:text-gray-200 leading-tight">
                <a href="{{ route('tasks.index') }}" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">
                    Listar Tarefas
                </a>
            </h3>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="/tasks" method="POST">
                        @csrf <!-- Include this line if you're using Laravel Blade -->

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Título</label>
                            <input type="text" id="title" name="title" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o título da tarefa">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Descrição</label>
                            <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite a descrição da tarefa" rows="4"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Prazo</label>
                            <input type="datetime-local" id="deadline" name="deadline" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Criar Tarefa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
