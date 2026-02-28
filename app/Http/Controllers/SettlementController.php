<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use App\Models\Colocation;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        Settlement::create([
            'amount' => $request->amount,
            'paid_at' => now(),
            'payer_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'colocation_id' => $colocation->id,
        ]);

        return redirect()->back()->with('success', 'Règlement enregistré !');
    }

    public function destroy(Settlement $settlement)
    {
        $settlement->delete();
        return redirect()->back()->with('success', 'Règlement supprimé.');
    }
}
