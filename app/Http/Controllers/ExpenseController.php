<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'amount' => 'required',
            'date' => 'required|date',
            'category_id' => 'nullable'
        ]);

        $colocation->expenses()->create(array_merge(
            $validated,
            ['user_id' => $request->user()->id]
        ));

        return redirect()->route('colocations.show', $colocation);
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $expense->delete();
        return redirect()->back();
    }
}
