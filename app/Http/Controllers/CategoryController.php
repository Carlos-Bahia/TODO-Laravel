<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $categories = Category::where('created_for', $user->id)
                                ->withCount('tasks')
                                ->orderBy('created_at', 'DESC')
                                ->paginate(6)
                                ->onEachSide(1);

        return view('categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20',
            'description' => 'required|string',
            'color' => 'required|string',
        ]);

        try {
            Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color,
                'created_for' => $request->user()->id,
            ]);

            return redirect()->route('categories.index');

        } catch (\Throwable $th) {

            if ($th->getCode() === '23000') {

                return back()->with('error', 'Já Existe uma Categoria com esse nome. Tente Novamente!');

            } else {
                return back()->with('error', 'Erro interno. Tente Novamente mais tarde!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:20',
            'description' => 'required|string',
            'color' => 'required|string',
        ]);

        try {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'color' => $request->color
            ]);

            return redirect()->route('categories.index');

        } catch (\Throwable $th) {

            if ($th->getCode() === '23000') {

                return back()->with('error', 'Já Existe uma Categoria com esse nome. Tente Novamente!');

            } else {
                return back()->with('error', $th->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $category->delete();
            return response()->json(['success' => 'Categoria excluída com sucesso!'], 201);
        }

        return response()->json(['error' => 'Categoria não removida. Tente novamente!'], 400);
    }
}
