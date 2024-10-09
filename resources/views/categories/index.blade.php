<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Listar Categorias') }}
            </h2>

            <h3 class="font-semibold text-x text-gray-800 dark:text-gray-200 leading-tight">
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">
                    Criar Categoria
                </a>
            </h3>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div id="task-table" class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 text-center uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b-2 border-gray-500">
                        <tr class="text-nowrap a">
                            <td class="px-3 py-3">Nome</td>
                            <td class="px-3 py-3">Descrição</td>
                            <td class="px-3 py-3">Cor de destaque</td>
                            <td class="px-5 py-3">Nº de Atividades</td>
                            <td class="px-6 py-3">Ações</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-3 py-2">{{ $category->name }}</td>
                                    <td class="px-3 py-2">{{ $category->description }}</td>
                                    <td class="px-3 py-2">
                                        <div>
                                            <div class="px-6 py-3 rounded" style="background-color: {{ $category->color }};">
                                            </div>
                                        </div>

                                    </td>
                                    <td class="px-3 py-2">{{ $category->tasks_count }}</td>
                                    <td class="px-3 py-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning text-blue-400">Editar</a>
                                        <br/>
                                        <button type="button" class="btn btn-danger text-red-500" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteFormAction('{{ route('categories.destroy', $category) }}')">
                                            Deletar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <nav class="text-center mt-4">
                        {{ $categories->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmação -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h5 class="text-lg font-bold mb-4">Confirmar Exclusão</h5>
            <p>Você tem certeza que deseja excluir esta categoria?</p>
            <div class="mt-4">
                <button id="cancelButton" class="mr-2 px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                <form id="deleteForm" action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Deletar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function setDeleteFormAction(action) {
            $('#deleteForm').attr('action', action);
            $('#deleteModal').removeClass('hidden');
        }

        $('#cancelButton').on('click', function() {
            $('#deleteModal').addClass('hidden');
        });

        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    localStorage.setItem('successMessage', response.success);
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        localStorage.setItem('errorMessage', xhr.responseJSON.error);
                    } else {
                        localStorage.setItem('errorMessage', 'Ocorreu um erro ao tentar excluir a tarefa.');
                    }
                    location.reload();
                }
            });

            $('#deleteModal').addClass('hidden');
        });

    </script>

    <script>
        $(document).ready(function() {
            // Mensagem de sucesso da sessão
            @if (session('success'))
            toastr.success('{{ session('success') }}');
            @endif

            // Mensagem de erro da sessão
            @if (session('error'))
            toastr.error('{{ session('error') }}');
            @endif

            // Captura mensagens de sucesso e erro do LocalStorage após a exclusão via AJAX
            const successMessage = localStorage.getItem('successMessage');
            const errorMessage = localStorage.getItem('errorMessage');

            if (successMessage) {
                toastr.success(successMessage);
                localStorage.removeItem('successMessage');
            }

            if (errorMessage) {
                toastr.error(errorMessage);
                localStorage.removeItem('errorMessage');
            }
        });
    </script>
</x-app-layout>
