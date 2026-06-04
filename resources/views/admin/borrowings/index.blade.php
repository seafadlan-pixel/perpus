<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Borrowing Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .sidebar { background: #0f172a; min-height: 100vh; color: white; padding-top: 24px; box-shadow: 1px 0 0 #e2e8f0; display: flex; flex-direction: column; }
        .sidebar h4 { font-size: 1.1rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em; opacity: 0.95; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 12px 24px; display: block; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .main-content { padding: 40px; }
        .card { border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); background-color: #ffffff; overflow: hidden; }

        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            flex: 1;
            background: white;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 4px;
            color: #0f172a;
        }

        .stat-card .stat-label {
            font-size: 0.65rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .filter-tab {
            padding: 6px 16px;
            border-radius: 6px;
            background: white;
            color: #475569;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            transition: all 0.15s;
        }

        .filter-tab:hover, .filter-tab.active {
            background: #0f172a;
            color: white;
            border-color: #0f172a;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }

        .badge-pending { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .badge-approved { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-returned { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .badge-rejected { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-approve {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .btn-approve:hover {
            background: #1d4ed8;
            color: white;
            border-color: #1d4ed8;
        }

        .btn-reject {
            background: #fffbeb;
            color: #b45309;
            border-color: #fde68a;
        }
        .btn-reject:hover {
            background: #d97706;
            color: white;
            border-color: #d97706;
        }

        .btn-return {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }
        .btn-return:hover {
            background: #047857;
            color: white;
            border-color: #047857;
        }

        .btn-delete-borrow {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }
        .btn-delete-borrow:hover {
            background: #b91c1c;
            color: white;
            border-color: #b91c1c;
        }

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

        .borrower-info .name {
            font-weight: 600;
            color: #0f172a;
        }

        .borrower-info .phone {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 2px;
        }

        .overdue-badge {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px; position: sticky; top: 0; height: 100vh;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}">📚 Book Management</a>
        <a href="{{ route('admin.borrowings.index') }}" class="active">📋 Borrowing Management</a>
        <a href="{{ route('admin.users.index') }}">👥 Member List</a>
        <a href="{{ route('public.index') }}">🌍 View Public Site</a>
        <div class="mt-auto px-3 pb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Borrowing Management</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="stats-row">
            <div class="stat-card stat-pending">
                <div class="stat-number">{{ $borrowings->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card stat-approved">
                <div class="stat-number">{{ $borrowings->where('status', 'approved')->count() }}</div>
                <div class="stat-label">Dipinjam</div>
            </div>
            <div class="stat-card stat-returned">
                <div class="stat-number">{{ $borrowings->where('status', 'returned')->count() }}</div>
                <div class="stat-label">Dikembalikan</div>
            </div>
            <div class="stat-card stat-rejected">
                <div class="stat-number">{{ $borrowings->where('status', 'rejected')->count() }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="{{ route('admin.borrowings.index') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">Semua</a>
            <a href="{{ route('admin.borrowings.index', ['status' => 'pending']) }}" class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">⏳ Pending</a>
            <a href="{{ route('admin.borrowings.index', ['status' => 'approved']) }}" class="filter-tab {{ request('status') == 'approved' ? 'active' : '' }}">✅ Dipinjam</a>
            <a href="{{ route('admin.borrowings.index', ['status' => 'returned']) }}" class="filter-tab {{ request('status') == 'returned' ? 'active' : '' }}">📦 Dikembalikan</a>
            <a href="{{ route('admin.borrowings.index', ['status' => 'rejected']) }}" class="filter-tab {{ request('status') == 'rejected' ? 'active' : '' }}">❌ Ditolak</a>
        </div>

        <!-- Borrowings Table -->
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Dikembalikan</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($borrowings as $borrowing)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td>
                                <div class="borrower-info">
                                    <div class="name">{{ $borrowing->borrower_name }}</div>
                                    <div class="phone">📞 {{ $borrowing->borrower_phone }}</div>
                                    @if($borrowing->user && $borrowing->user->class)
                                        <div style="margin-top: 4px;">
                                            <span class="badge-status badge-approved" style="padding: 2px 6px; font-size: 0.7rem;">🏫 {{ $borrowing->user->class }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $borrowing->book->title }}</div>
                                <small class="text-muted">{{ $borrowing->book->author }}</small>
                            </td>
                            <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                            <td>
                                {{ $borrowing->due_date->format('d M Y') }}
                                @if($borrowing->status === 'approved' && $borrowing->due_date->isPast())
                                    <br><span class="overdue-badge">⚠️ Terlambat</span>
                                @endif
                            </td>
                            <td>
                                @if($borrowing->return_date)
                                    {{ $borrowing->return_date->format('d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($borrowing->status)
                                    @case('pending')
                                        <span class="badge-status badge-pending">⏳ Pending</span>
                                        @break
                                    @case('approved')
                                        <span class="badge-status badge-approved">✅ Dipinjam</span>
                                        @break
                                    @case('returned')
                                        <span class="badge-status badge-returned">📦 Dikembalikan</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge-status badge-rejected">❌ Ditolak</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-1 justify-content-end">
                                    @if($borrowing->status === 'pending')
                                        <form action="{{ route('admin.borrowings.approve', $borrowing->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-approve" onclick="return confirm('Approve peminjaman ini?')">✅ Approve</button>
                                        </form>
                                        <form action="{{ route('admin.borrowings.reject', $borrowing->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-reject" onclick="return confirm('Tolak peminjaman ini?')">❌ Reject</button>
                                        </form>
                                    @endif

                                    @if($borrowing->status === 'approved')
                                        <form action="{{ route('admin.borrowings.return', $borrowing->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn btn-return" onclick="return confirm('Tandai buku sudah dikembalikan?')">📦 Return</button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.borrowings.destroy', $borrowing->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete-borrow" onclick="return confirm('Hapus data peminjaman ini?')">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <div style="font-size: 3rem; margin-bottom: 12px;">📋</div>
                                <h5>Belum ada data peminjaman</h5>
                                <p class="mb-0" style="font-size: 0.9rem;">Data peminjaman akan muncul setelah user mengajukan peminjaman buku.</p>
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
