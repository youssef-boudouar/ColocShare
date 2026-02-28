<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $active = $user->colocations()
            ->where('status', 'active')
            ->first();

        $past = $user->colocations()
            ->where('status', 'cancelled')
            ->get();

        return view('colocations.index', compact('active', 'past'));
    }

    public function create()
    {
        return view('colocations.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        $colocation = Colocation::create($validated);

        $colocation->users()->attach($request->user()->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('dashboard');
    }
    public function show(Colocation $colocation)
    {
        return view('colocations.show', compact('colocation'));
    }
    public function edit(Colocation $colocation)
    {
        if ($colocation->users()->wherePivot('role', 'owner')->where('users.id', auth()->id())->doesntExist()) {
            abort(403);
        }

        return view('colocations.edit', compact('colocation'));
    }
    public function update(Request $request, Colocation $colocation)
    {
        if ($colocation->users()->wherePivot('role', 'owner')->where('users.id', auth()->id())->doesntExist()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $colocation->update($validated);

        return redirect()->route('colocations.show', $colocation)
            ->with('success', 'Colocation mise à jour.');
    }

    public function cancel(Colocation $colocation)
    {
        if ($colocation->users()->wherePivot('role', 'owner')->where('users.id', auth()->id())->doesntExist()) {
            abort(403);
        }

        $colocation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Colocation annulée.');
    }
}
