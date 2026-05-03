<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_admin')) {
            $query->where('is_admin', $request->input('is_admin'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->input('status') === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $perPage = $request->input('per_page', 10);
        if (!in_array($perPage, [5, 10, 25])) {
            $perPage = 10;
        }

        $users = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if (!$user->email_verified_at) {
            return back()->with('error', 'Nur aktivierte Benutzer können zum Admin gemacht werden.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Sie können sich nicht selbst die Admin-Rechte entziehen.');
        }

        $user->is_admin = !$user->is_admin;
        $user->save();

        $status = $user->is_admin ? 'Admin-Rechte gewährt' : 'Admin-Rechte entzogen';
        return back()->with('success', "Benutzer {$user->name}: {$status}.");
    }

    public function toggleVerification(User $user)
    {
        // Ein Admin sollte sich nicht selbst deaktivieren können
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Sie können Ihren eigenen Aktivierungsstatus nicht ändern.');
        }

        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $status = 'deaktiviert';
            // Wenn der User deaktiviert wird, entziehen wir ihm auch die Admin-Rechte (Sicherheitsregel aus vorigem Schritt)
            $user->is_admin = false;
        } else {
            $user->email_verified_at = now();
            $status = 'aktiviert';
        }

        $user->save();

        return back()->with('success', "Benutzer {$user->name} wurde {$status}.");
    }

    public function destroy(User $user)
    {
        // Ein Admin kann sich nicht selbst löschen
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Sie können sich nicht selbst löschen.');
        }

        $userName = $user->name;
        $user->delete();

        return back()->with('success', "Benutzer {$userName} wurde erfolgreich gelöscht.");
    }
}
