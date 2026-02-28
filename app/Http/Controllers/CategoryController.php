<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        if ($colocation->users()->wherePivot('role', 'owner')->where('users.id', auth()->id())->doesntExist()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $colocation->categories()->create($validated);
        return redirect()->route('colocations.show', $colocation);
    }

    public function destroy(Category $category)
    {
        $colocation = $category->colocation;
        if ($colocation->users()->wherePivot('role', 'owner')->where('users.id', auth()->id())->doesntExist()) {
            abort(403);
        }

        $category->delete();
        return redirect()->back();
    }
}
