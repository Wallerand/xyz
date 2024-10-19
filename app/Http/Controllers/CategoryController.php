<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * Show available categories.
     */
    public function index(): View
    {
        return view('app.categories.index', [
            'categories' => Category::orderBy('name')->withCount('tracks')->get(),
        ]);
    }

    /**
     * Show given category.
     */
    public function show(Category $category): View
    {
        return view('app.categories.show', [
            'category' => $category,
            'tracks' => $category->tracks()
                ->with('week')
                ->withCount('likes')
                ->ranking()
                ->paginate(10),
        ]);
    }
}
