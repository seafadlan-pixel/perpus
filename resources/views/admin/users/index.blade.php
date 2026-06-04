<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Member Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .sidebar { background: #0f172a; min-height: 100vh; color: white; padding-top: 24px; box-shadow: 1px 0 0 #e2e8f0; }
        .sidebar h4 { font-size: 1.1rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em; opacity: 0.95; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 12px 24px; display: block; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .main-content { padding: 40px; }
        .card { border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); background-color: #ffffff; overflow: hidden; }

        .badge-status {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        .badge-class { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-role { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            background: #fafafa;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 20px;
        }

        .table tbody td {
            vertical-align: middle;
            font-size: 0.875rem;
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}">📚 Book Management</a>
        <a href="{{ route('admin.borrowings.index') }}">📋 Borrowing Management</a>
        <a href="{{ route('admin.users.index') }}" class="active">👥 Member List</a>
        <a href="{{ route('public.index') }}">🌍 View Public Site</a>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto px-3 pb-4" style="position: absolute; bottom: 0; width: 250px;">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Anggota / Siswa</h2>
            <div class="text-muted" style="font-size: 0.9rem;">Total: {{ $users->count() }} Anggota Terdaftar</div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Siswa / Anggota</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Role</th>
                            <th>Tgl Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->class)
                                    <span class="badge-status badge-class">🏫 {{ $user->class }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-status badge-role">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y - H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <div style="font-size: 3rem; margin-bottom: 12px;">👥</div>
                                <h5>Belum ada siswa yang mendaftar</h5>
                                <p class="mb-0" style="font-size: 0.9rem;">Siswa yang membuat akun akan terdaftar di sini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
