<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Listar Tarefas') }}
            </h2>

            <h3 class="font-semibold text-x text-gray-800 dark:text-gray-200 leading-tight">
                <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">
                    Criar Tarefa
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
                            <th class="px-3 py-3">Título</th>
                            <th class="px-3 py-3">Descrição</th>
                            <th class="px-3 py-3">Categorias</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-3 py-3">Data de Entrega</th>
                            <th class="px-3 py-3">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-3 py-2">{{ $task->title }}</td>
                                <td class="px-3 py-2">{{ $task->description }}</td>
                                <td class="px-3 py-2">
                                    @foreach($task->categories as $category)
                                        <span class="text-nowrap">{{ $category->name }}</span> <br/>
                                    @endforeach
                                </td>
                                @if($task->is_completed === 1)
                                    <td class="px-3 py-2">
                                        <span class="bg-green-500 text-white rounded-lg px-4 py-2">Finalizado</span>
                                    </td>
                                @else
                                    <td class="px-3 py-2">
                                        <span class="bg-red-500 text-white rounded-lg px-4 py-2">Pendente</span>
                                    </td>
                                @endif
                                <td class="px-3 py-2">
                                    {{ $task->getDeadlineAttribute()->format('d/m/Y') }}<br>
                                    {{ $task->getDeadlineAttribute()->format('H:i') }}
                                </td>

                                <td class="px-3 py-2">
                                    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning text-blue-400">Editar</a>
                                    <br/>
                                    <button type="button" class="btn btn-danger text-red-500" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteFormAction('{{ route('tasks.destroy', $task) }}')">
                                        Deletar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <nav class="text-center mt-4">
                        {{ $tasks->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmação -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h5 class="text-lg font-bold mb-4">Confirmar Exclusão</h5>
            <p>Você tem certeza que deseja excluir esta tarefa?</p>
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

            $('#deleteModal').addClass('hidden'); // Fecha o modal após o envio
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Restaura o scroll da página ao carregar
            const url = new URL(window.location.href);
            const page = parseInt(url.searchParams.get('page'));
            if(page && page !== 1) {
                let lastScrollY = localStorage.getItem('lastScrollPosition');
                if (lastScrollY) {
                    // Função para rolar suavemente de forma personalizada
                    function smoothScrollTo(endPosition, duration) {
                        const startPosition = window.scrollY;
                        const distance = endPosition - startPosition;
                        let startTime = null;

                        function animation(currentTime) {
                            if (startTime === null) startTime = currentTime;
                            const timeElapsed = currentTime - startTime;
                            const progress = Math.min(timeElapsed / duration, 1); // Limita o valor de progress a 1
                            const easing = 1 - Math.pow(1 - progress, 3); // Curva de aceleração personalizada (easing)

                            window.scrollTo(0, startPosition + distance * easing);

                            if (timeElapsed < duration) {
                                requestAnimationFrame(animation);
                            }
                        }

                        requestAnimationFrame(animation);
                    }

                    // Obtém a tabela ou o elemento desejado
                    const tableElement = document.getElementById('task-table');

                    if (tableElement) {
                        // Calcula a posição do elemento em relação ao topo da página
                        const tablePosition = tableElement.getBoundingClientRect().top + window.scrollY;

                        // Chama a função de rolagem suave para a posição da tabela
                        smoothScrollTo(tablePosition, 1500);
                    }
                }
            }

            // Salva a posição do scroll antes da página ser descarregada (navegação ou paginação)
            window.addEventListener('beforeunload', function() {
                localStorage.setItem('lastScrollPosition', window.scrollY);
            });

            // Limpa o armazenamento local ao navegar para outra página que não seja a de tarefas
            document.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (!this.href.includes('tasks')) {
                        localStorage.removeItem('lastScrollPosition');
                    }
                });
            });
        });
    </script>

</x-app-layout>
