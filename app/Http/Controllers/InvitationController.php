<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Colocation;
use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function send(Request $request, Colocation $colocation)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Aucun utilisateur trouvé avec cet email.');
        }

        if ($colocation->users()->where('users.id', $user->id)->wherePivotNull('left_at')->exists()) {
            return redirect()->back()->with('error', 'Cet utilisateur est déjà membre.');
        }

        Mail::to($request->email)->send(new InvitationMail($colocation));

        return redirect()->back()->with('success', 'Invitation envoyée !');
    }

    public function accept($token)
    {
        $colocation = Colocation::where('invite_token', $token)->first();

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'Lien invalide.');
        }

        if ($colocation->users()->where('users.id', auth()->id())->wherePivotNull('left_at')->exists()) {
            return redirect()->route('colocations.show', $colocation)->with('error', 'Vous êtes déjà membre.');
        }

        $colocation->users()->attach(auth()->id(), [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('success', 'Vous avez rejoint la colocation !');
    }
}


