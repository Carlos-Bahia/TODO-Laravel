<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        //BigNumbers
        $numTasks = Task::query()->count();

        $onDeadline = Task::query()->where('is_completed', '0')->whereDate('deadline', '>', now())->count();

        $numPendingTasks = Task::query()->where('is_completed', '0')->count();

        $numCompleteTasks = Task::query()->where('is_completed', '1')->count();

        $numRightDeadlineTasks = Task::query()->whereColumn('completed_at', '<=', 'deadline')->count();

        // AnnualPerformance
        $annualPerformance = Task::selectRaw('YEAR(deadline) as year, COUNT(*) as total_tasks, SUM(is_completed) as completed_tasks')
            ->groupBy('year')
            ->having('year', '<=', now()->year)
            ->orderBy('year')
            ->get()
            ->map(function($item) {
                $item->completion_rate = $item->total_tasks > 0 ? ($item->completed_tasks / $item->total_tasks) * 100 : 0;
                return $item;
            });

        //TopCategories
        $topCategories = DB::table('categories')
            ->select('categories.name', DB::raw('COUNT(category_task.task_id) as total_tasks'), DB::raw('SUM(tasks.is_completed) as completed_tasks'))
            ->join('category_task', 'categories.id', '=', 'category_task.category_id')
            ->join('tasks', 'category_task.task_id', '=', 'tasks.id')
            ->groupBy('categories.name')
            ->havingRaw('total_tasks > 0') // Certifique-se de que total_tasks é maior que 0
            ->orderByRaw('SUM(tasks.is_completed) / COUNT(category_task.task_id) DESC') // Ordena pela taxa de conclusão
            ->limit(10)
            ->get()
            ->map(function($item) {
                $item->performance = number_format(($item->completed_tasks / $item->total_tasks) * 100, 2);
                return $item;
            });

        return view('dashboard', [
            'numTasks' => $numTasks,
            'onDeadline' => $onDeadline,
            'numPendingTasks' => $numPendingTasks,
            'numCompleteTasks' => $numCompleteTasks,
            'numRightDeadlineTasks' => $numRightDeadlineTasks,
            'annualPerformance' => $annualPerformance,
            'topCategories' => $topCategories,
        ]);
    }
}
