<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        // Ambil data siswa/visitor yang terdaftar beserta kelasnya dan data peminjamannya
        $users = User::where('role', 'visitor')->with(['borrowings.book'])->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }
}
