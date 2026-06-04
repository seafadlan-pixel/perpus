<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .sidebar { background: #0f172a; min-height: 100vh; color: white; padding-top: 24px; box-shadow: 1px 0 0 #e2e8f0; }
        .sidebar h4 { font-size: 1.1rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em; opacity: 0.95; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 12px 24px; display: block; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .main-content { padding: 40px; }
        .card { border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background-color: #ffffff; overflow: hidden; }

        .badge-status { padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 500; display: inline-block; }
        .badge-class { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-role { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        .table thead th {
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
            color: #475569; background: #fafafa; border-bottom: 1px solid #e2e8f0; padding: 14px 20px;
        }
        .table tbody td { vertical-align: middle; font-size: 0.875rem; padding: 16px 20px; border-bottom: 1px solid #f1f5f9; }
        .table tbody tr:last-child td { border-bottom: none; }

        .avatar-sm { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }

        /* Modal borrowing table */
        .modal-borrowing-table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; color: #64748b; }
        .fine-badge { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 3px 8px; border-radius: 5px; font-size: 0.78rem; font-weight: 600; }
        .fine-badge.no-fine { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }

        .btn-fine { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none; font-size: 0.8rem; padding: 5px 12px; border-radius: 6px; font-weight: 500; transition: all 0.2s; }
        .btn-fine:hover { background: linear-gradient(135deg, #d97706, #b45309); color: white; transform: translateY(-1px); }

        .status-pill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 500; }
        .status-pending { background: #fef9c3; color: #a16207; }
        .status-approved { background: #dcfce7; color: #15803d; }
        .status-returned { background: #e0e7ff; color: #4338ca; }
        .status-rejected { background: #fee2e2; color: #b91c1c; }

        .alert-flash { border-radius: 10px; font-size: 0.875rem; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px; position: sticky; top: 0; height: 100vh;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}">📚 Book Management</a>
        <a href="{{ route('admin.borrowings.index') }}">📋 Borrowing Management</a>
        <a href="{{ route('admin.users.index') }}" class="active">👥 Member List</a>
        <a href="{{ route('public.index') }}">🌍 View Public Site</a>
        <form action="{{ route('logout') }}" method="POST" style="position: absolute; bottom: 20px; width: 250px; padding: 0 16px;">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">

        @if(session('success'))
            <div class="alert alert-success alert-flash alert-dismissible fade show mb-4" role="alert">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-flash alert-dismissible fade show mb-4" role="alert">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Daftar Anggota / Siswa</h2>
                <p class="text-muted mt-1 mb-0" style="font-size: 0.9rem;">Kelola anggota dan denda peminjaman</p>
            </div>
            <div class="text-muted" style="font-size: 0.9rem;">
                <strong>{{ $users->count() }}</strong> Anggota Terdaftar
            </div>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Anggota</th>
                            <th>Email</th>
                            <th>Kelas</th>
                            <th>Role</th>
                            <th>Peminjaman</th>
                            <th>Terdaftar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f172a&color=ffffff&size=72&rounded=true&bold=true"
                                        alt="{{ $user->name }}"
                                        class="avatar-sm"
                                    >
                                    <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
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
                            <td>
                                @php
                                    $activeBorrowings = $user->borrowings->whereIn('status', ['pending', 'approved'])->count();
                                    $totalFine = $user->borrowings->sum('fine_amount');
                                @endphp
                                <div class="d-flex flex-column gap-1">
                                    <span class="text-dark fw-medium" style="font-size: 0.82rem;">
                                        {{ $user->borrowings->count() }} peminjaman
                                    </span>
                                    @if($totalFine > 0)
                                        <span class="fine-badge">💰 Denda: Rp {{ number_format($totalFine, 0, ',', '.') }}</span>
                                    @else
                                        <span class="fine-badge no-fine">✅ Bebas denda</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-muted" style="font-size: 0.82rem;">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-dark rounded-3 px-3"
                                    style="font-size: 0.8rem;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalUser{{ $user->id }}"
                                >
                                    📋 Peminjaman & Denda
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
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

<!-- ============================================================
     MODALS: Peminjaman & Denda per User
     ============================================================ -->
@foreach ($users as $user)
<div class="modal fade" id="modalUser{{ $user->id }}" tabindex="-1" aria-labelledby="modalUser{{ $user->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 25px 50px rgba(0,0,0,0.15);">

            <div class="modal-header" style="background: #0f172a; border-radius: 14px 14px 0 0; padding: 20px 28px;">
                <div class="d-flex align-items-center gap-3">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=334155&color=ffffff&size=80&rounded=true&bold=true"
                        alt="{{ $user->name }}"
                        style="width: 44px; height: 44px; border-radius: 50%;"
                    >
                    <div>
                        <h5 class="modal-title text-white mb-0 fw-bold" id="modalUser{{ $user->id }}Label">
                            {{ $user->name }}
                        </h5>
                        <div class="text-secondary" style="font-size: 0.82rem;">{{ $user->email }} · {{ $user->class ?? 'Tanpa kelas' }}</div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                @php
                    $totalFineUser = $user->borrowings->sum('fine_amount');
                    $activeBorrowingsUser = $user->borrowings->whereIn('status', ['pending', 'approved'])->count();
                @endphp

                <!-- Ringkasan -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-center" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #0f172a;">{{ $user->borrowings->count() }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">Total Peminjaman</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-center" style="background: #fef9c3; border: 1px solid #fde68a;">
                            <div style="font-size: 1.5rem; font-weight: 700; color: #92400e;">{{ $activeBorrowingsUser }}</div>
                            <div style="font-size: 0.8rem; color: #92400e;">Sedang Dipinjam</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-3 text-center" style="background: {{ $totalFineUser > 0 ? '#fef2f2' : '#f0fdf4' }}; border: 1px solid {{ $totalFineUser > 0 ? '#fecaca' : '#bbf7d0' }};">
                            <div style="font-size: 1.5rem; font-weight: 700; color: {{ $totalFineUser > 0 ? '#dc2626' : '#16a34a' }};">
                                Rp {{ number_format($totalFineUser, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 0.8rem; color: {{ $totalFineUser > 0 ? '#dc2626' : '#16a34a' }};">Total Denda</div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Peminjaman -->
                @if($user->borrowings->count() > 0)
                    <h6 class="fw-bold mb-3" style="color: #0f172a; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">📚 Riwayat Peminjaman</h6>
                    <div class="table-responsive">
                        <table class="table modal-borrowing-table align-middle" style="font-size: 0.85rem;">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th style="padding: 10px 14px;">No</th>
                                    <th style="padding: 10px 14px;">Judul Buku</th>
                                    <th style="padding: 10px 14px;">Status</th>
                                    <th style="padding: 10px 14px;">Tgl Pinjam</th>
                                    <th style="padding: 10px 14px;">Tgl Kembali</th>
                                    <th style="padding: 10px 14px;">Denda Saat Ini</th>
                                    <th style="padding: 10px 14px; text-align: center;">Atur Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->borrowings as $i => $borrowing)
                                <tr>
                                    <td style="padding: 12px 14px; color: #94a3b8;">{{ $i + 1 }}</td>
                                    <td style="padding: 12px 14px;">
                                        <span class="fw-semibold" style="color: #0f172a;">
                                            {{ $borrowing->book ? $borrowing->book->title : '— Buku dihapus —' }}
                                        </span>
                                        @if($borrowing->book)
                                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $borrowing->book->author ?? '' }}</div>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 14px;">
                                        @php
                                            $statusLabels = [
                                                'pending'  => ['class' => 'status-pending',  'label' => '⏳ Pending'],
                                                'approved' => ['class' => 'status-approved', 'label' => '✅ Dipinjam'],
                                                'returned' => ['class' => 'status-returned', 'label' => '📦 Dikembalikan'],
                                                'rejected' => ['class' => 'status-rejected', 'label' => '❌ Ditolak'],
                                            ];
                                            $st = $statusLabels[$borrowing->status] ?? ['class' => '', 'label' => $borrowing->status];
                                        @endphp
                                        <span class="status-pill {{ $st['class'] }}">{{ $st['label'] }}</span>
                                    </td>
                                    <td style="padding: 12px 14px; color: #64748b;">
                                        {{ $borrowing->created_at->format('d M Y') }}
                                    </td>
                                    <td style="padding: 12px 14px; color: #64748b;">
                                        {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') : '—' }}
                                    </td>
                                    <td style="padding: 12px 14px;">
                                        @if($borrowing->fine_amount > 0)
                                            <span class="fine-badge">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                        @else
                                            <span class="fine-badge no-fine">Rp 0</span>
                                        @endif
                                    </td>
                                    <td style="padding: 12px 14px; text-align: center;">
                                        <!-- Form update denda -->
                                        <form action="{{ route('admin.borrowings.update_fine', $borrowing->id) }}" method="POST" class="d-flex align-items-center gap-2 justify-content-center">
                                            @csrf
                                            @method('PATCH')
                                            <input
                                                type="number"
                                                name="fine_amount"
                                                value="{{ $borrowing->fine_amount ?? 0 }}"
                                                min="0"
                                                step="1000"
                                                class="form-control form-control-sm"
                                                style="width: 120px; font-size: 0.82rem; border-radius: 7px;"
                                                placeholder="Rp 0"
                                            >
                                            <button type="submit" class="btn-fine">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <div style="font-size: 3rem; margin-bottom: 12px;">📭</div>
                        <h6>Belum ada riwayat peminjaman</h6>
                        <p class="mb-0" style="font-size: 0.85rem;">Anggota ini belum pernah meminjam buku.</p>
                    </div>
                @endif

            </div>

            <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 14px 14px; border-top: 1px solid #e2e8f0; padding: 16px 24px;">
                <button type="button" class="btn btn-outline-secondary btn-sm rounded-3 px-4" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
