<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'visitor')
            ->with(['borrowings.book'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function toggleActive(User $user)
    {
        // Jangan izinkan nonaktifkan admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun admin tidak dapat dinonaktifkan.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }
}
