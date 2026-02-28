<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    public function send(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if current user is the owner
        if ($colocation->users()->wherePivot('role', 'owner')->where('users.id', auth()->id())->doesntExist()) {
            abort(403);
        }

        // Find user by email
        $invitedUser = User::where('email', $request->email)->first();

        if (!$invitedUser) {
            return back()->with('error', 'Aucun utilisateur trouvé avec cet email.');
        }

        // Check if already a member of this colocation
        if ($colocation->users()->where('users.id', $invitedUser->id)->exists()) {
            return back()->with('error', 'Cet utilisateur est déjà membre.');
        }

        // Check if user already has an active colocation
        $hasActive = $invitedUser->colocations()->where('status', 'active')->wherePivotNull('left_at')->exists();
        if ($hasActive) {
            return back()->with('error', 'Cet utilisateur a déjà une colocation active.');
        }

        // Send the invitation email
        Mail::to($request->email)->send(new InvitationMail($colocation));

        return back()->with('success', 'Invitation envoyée !');
    }

    public function accept(Colocation $colocation)
    {
        $user = auth()->user();

        // Check if user already has an active colocation
        $hasActive = $user->colocations()->where('status', 'active')->wherePivotNull('left_at')->exists();
        if ($hasActive) {
            return redirect()->route('dashboard')->with('error', 'Vous avez déjà une colocation active.');
        }

        // Check if already a member
        if ($colocation->users()->where('users.id', $user->id)->exists()) {
            return redirect()->route('colocations.show', $colocation)->with('error', 'Vous êtes déjà membre de cette colocation.');
        }

        // Add user to colocation
        $colocation->users()->attach(auth()->id(), [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('success', 'Vous avez rejoint la colocation !');
    }
}
