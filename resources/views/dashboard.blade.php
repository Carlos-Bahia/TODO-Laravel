<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex justify-between">
                    <div class="w-1/5 px-3 py-2 text-center bg-gray-300 dark:bg-gray-900 rounded-xl">
                        <span class="text-6xl">{{ $numTasks }}</span>
                        <p class="text-sm">Total de Atividades</p>
                        <p class="text-xs text-gray-500">({{ $onDeadline }} dentro do prazo)</p>
                    </div>
                    <div class="w-1/5 px-3 py-2 text-center bg-gray-300 dark:bg-gray-900 rounded-xl">
                        <span class="text-6xl">{{ $numPendingTasks }}</span>
                        <p class="text-sm">Total de Atividades Pendentes</p>
                        <p class="text-xs text-gray-500">{{ $numTasks ? number_format(($numPendingTasks/$numTasks ) * 100, 2) : 0}}%</p>
                    </div>
                    <div class="w-1/5 px-3 py-2 text-center bg-gray-300 dark:bg-gray-900 rounded-xl">
                        <span class="text-6xl">{{ $numCompleteTasks }}</span>
                        <p class="text-sm">Total de Atividades Concluídas</p>
                        <p class="text-xs text-gray-500">{{ $numTasks ? number_format(($numCompleteTasks/$numTasks ) * 100, 2)  : 0}}%</p>
                    </div>
                    <div class="w-1/5 px-3 py-2 text-center bg-gray-300 dark:bg-gray-900 rounded-xl">
                        <span class="text-6xl">{{ $numTasks ?  number_format(($numRightDeadlineTasks/$numTasks ) * 100, 2) : 0 }}%</span>
                        <p class="text-sm">Porcentagem de Atividades Concluídas no Prazo</p>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/2 rounded m-4 p-4 bg-gray-900">
                        <div class="grid justify-center text-center">
                            <h3 class="text-2xl text-white">Porcentagem de Atividades Concluídas por Ano</h3>
                            <canvas id="completionChart"></canvas>
                        </div>
                    </div>
                    <div class="w-1/2 rounded m-4 p-4 bg-gray-900">
                        <div class="grid justify-center text-center">
                            <h3 class="text-2xl text-white">Categorias com Melhor Aproveitamento</h3>
                            <canvas id="categoriesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('completionChart').getContext('2d');

        const labels = @json($annualPerformance->pluck('year'));
        const data = {
            labels: labels,
            datasets: [{
                label: 'Porcentagem de Atividades Concluídas ',
                data: @json($annualPerformance->pluck('completion_rate')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        };

        const completionChart = new Chart(ctx, config);
    </script>
    <script>
        const ctx2 = document.getElementById('categoriesChart').getContext('2d');

        const labels2 = @json($topCategories->pluck('name'));
        const data2 = {
            labels: labels2,
            datasets: [{
                label: 'Porcentagem de Atividades Concluídas',
                data: @json($topCategories->pluck('performance')),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        };

        const categoriesChart = new Chart(ctx2, config2);
    </script>

</x-app-layout>
