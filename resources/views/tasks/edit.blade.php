<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Tarefas') }}
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
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Título *</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o título da tarefa">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Descrição</label>
                            <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite a descrição da tarefa" rows="4">{{ old('description', $task->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Prazo *</label>
                            <input type="datetime-local" value="{{ old('deadline', $task->deadline->format('Y-m-d\TH:i')) }}" id="deadline" name="deadline" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="is_completed" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Status *</label>
                            <select name="is_completed" id="is_completed" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="0" {{ $task->is_completed == 0 ? 'selected' : '' }}>Pendente</option>
                                <option value="1" {{ $task->is_completed == 1 ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>

                        <div class="flex justify-between">
                            <div class="mb-4 w-1/2 mr-4">
                                <label for="categories" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Categoria 1 *</label>
                                <select name="category-1" id="category1"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="" disabled {{ !$task->categories->first() ? 'selected' : '' }}>Selecione uma Categoria</option>

                                    @foreach($categories as $category)
                                        <option style="color: {{ $category->color }}" value="{{ $category->id }}"
                                            {{ $task->categories->first() && $task->categories->first()->id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4  w-1/2 ml-4">
                                <label for="categories" class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Categoria 2</label>
                                <select name="category-2" id="category2"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline">

                                    <option value="" {{ !$task->categories->skip(1)->first() ? 'selected' : '' }}>Sem Categoria Secundária</option>

                                @foreach($categories as $category)
                                        <option style="color: {{ $category->color }}" value="{{ $category->id }}"
                                            {{ $task->categories->skip(1)->first() && $task->categories->skip(1)->first()->id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} <div class="px-6 py-3 rounded" style="background-color: {{ $category->color }};">
                                            </div>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div></div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Atualizar Tarefa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
