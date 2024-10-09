<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Categoria') }}
            </h2>

            <h3 class="font-semibold text-x text-gray-800 dark:text-gray-200 leading-tight">
                <a href="{{ route('categories.index') }}" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">
                    Listar Categorias
                </a>
            </h3>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex">
                            <div class="w-1/2 mr-4">
                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Nome da Categoria</label>
                                    <input type="text" id="name" name="name" value="{{ $category->name }}" maxlength="20" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o título da categoria">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Descrição</label>
                                    <textarea id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-800 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite a descrição da categoria" rows="4">{{ $category->description }}</textarea>
                                </div>
                            </div>

                            <div class="w-1/2 ml-4 md-4">
                                <label class="block text-gray-700 dark:text-gray-300 text-sm font-semibold mb-2">Cor de Destaque</label>
                                <div class="mb-4">
                                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                        <div class="w-full h-20 bg-red-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Red"></div>
                                        <div class="w-full h-20 bg-blue-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Blue"></div>
                                        <div class="w-full h-20 bg-green-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Green"></div>
                                        <div class="w-full h-20 bg-yellow-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Yellow"></div>
                                        <div class="w-full h-20 bg-black text-white rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Black"></div>
                                        <div class="w-full h-20 bg-white text-black rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="White"></div>
                                        <div class="w-full h-20 bg-purple-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Purple"></div>
                                        <div class="w-full h-20 bg-orange-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Orange"></div>
                                        <div class="w-full h-20 bg-pink-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Pink"></div>
                                        <div class="w-full h-20 bg-gray-500 rounded cursor-pointer transition-transform transform hover:scale-105 hover:shadow-lg color-box" data-color="Gray"></div>
                                    </div>

                                    <input type="hidden" id="selectedColorInput" name="color" value="{{$category->color}}">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Atualizar Categoria
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const colorBoxes = document.querySelectorAll('.color-box');
        const selectedColorDisplay = document.getElementById('selectedColor');
        const selectedColorInput = document.getElementById('selectedColorInput');

        colorBoxes.forEach(box => {
            box.addEventListener('click', function() {
                colorBoxes.forEach(b => b.classList.remove('border-4', 'border-black'));

                this.classList.add('border-4', 'border-black');

                const color = this.getAttribute('data-color');

                selectedColorInput.value = color;
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            @if (session('success'))
            toastr.success('{{ session('success') }}');
            @endif

            @if (session('error'))
            toastr.error('{{ session('error') }}');
            @endif

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
