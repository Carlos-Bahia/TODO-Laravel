<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $tasks = Task::where('created_by', $user->id)
            ->orderBy('is_completed', 'asc')
            ->orderBy('deadline', 'asc')
            ->paginate(6)
            ->onEachSide(1);

        return view('tasks.index', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        $categoriesAvaiable = Category::where('created_for', $user->id)
                              ->orderBy('name', 'asc')
                              ->get();

        return view('tasks.create', [
            'categories' => $categoriesAvaiable
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'category-1' => 'required|exists:categories,id',
            'category-2' => 'nullable|exists:categories,id',
        ]);

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'],
            'created_by' => $request->user()->id
        ]);

        $categoriesToSync = [$validatedData['category-1']];

        if (!empty($validatedData['category-2'])) {
            $categoriesToSync[] = $validatedData['category-2'];
        }

        $task->categories()->sync($categoriesToSync);

        return redirect()->route('tasks.index')->with('success', 'Tarefa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {

        $user = auth()->user();

        $categoriesAvaiable = Category::where('created_for', $user->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('tasks.edit', [
            'task' => $task,
            'categories' => $categoriesAvaiable
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'is_completed' => 'boolean',
            'category-1' => 'required|exists:categories,id',
            'category-2' => 'nullable|exists:categories,id',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'is_completed' => $request->is_completed
        ]);

        $categoriesToSync = [$validatedData['category-1']];

        if (!empty($validatedData['category-2'])) {
            $categoriesToSync[] = $validatedData['category-2'];
        }

        $task->categories()->sync($categoriesToSync);

        return redirect()->route('tasks.index')->with('success', 'Tarefa editada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task) {
            $task->delete();
            return response()->json(['success' => 'Tarefa excluída com sucesso!'], 201);
        }

        return response()->json(['error' => 'Tarefa não removida. Tente novamente!'], 400);
    }

}
