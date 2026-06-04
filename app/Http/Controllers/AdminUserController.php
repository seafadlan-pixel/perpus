<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil data siswa/visitor yang terdaftar beserta kelasnya
        $users = User::where('role', 'visitor')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
}
