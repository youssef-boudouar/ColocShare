<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $colocation->categories()->create($validated);
        return redirect()->route('colocations.show', $colocation);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}
