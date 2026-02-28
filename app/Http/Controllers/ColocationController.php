<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Settlement;
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
        $hasActive = auth()->user()->colocations()->where('status', 'active')->wherePivotNull('left_at')->exists();
        if ($hasActive) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active.');
        }

        return view('colocations.create');
    }
    public function store(Request $request)
    {
        $hasActive = auth()->user()->colocations()->where('status', 'active')->wherePivotNull('left_at')->exists();
        if ($hasActive) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active.');
        }

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
        $members = $colocation->users()->wherePivotNull('left_at')->get();
        $expenses = $colocation->expenses;
        $categories = $colocation->categories;
        $total = $expenses->sum('amount');
        $fairShare = $members->count() > 0 ? round($total / $members->count(), 2) : 0;

        $balances = [];
        foreach ($members as $member) {
            $paid = $expenses->where('user_id', $member->id)->sum('amount');
            $balances[] = [
                'user' => $member,
                'paid' => round($paid, 2),
                'balance' => round($paid - $fairShare, 2),
            ];
        }

        $settlements = Settlement::where('colocation_id', $colocation->id)->with(['payer', 'receiver'])->latest()->get();

        return view('colocations.show', compact('colocation', 'members', 'expenses', 'categories', 'total', 'fairShare', 'balances', 'settlements'));
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
