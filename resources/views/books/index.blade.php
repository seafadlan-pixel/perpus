<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Book Management</title>
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

        .btn-add-book {
            background: #0f172a;
            color: white;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 8px 16px;
            text-decoration: none;
            transition: all 0.15s;
            border: 1px solid #0f172a;
            display: inline-block;
        }
        .btn-add-book:hover {
            background: #1e293b;
            border-color: #1e293b;
            color: white;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        .badge-instock { background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .badge-outofstock { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .badge-neutral { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.15s;
        }

        .btn-edit {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .btn-edit:hover {
            background: #1d4ed8;
            color: white;
            border-color: #1d4ed8;
        }

        .btn-delete {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
            border-style: solid;
            border-width: 1px;
        }
        .btn-delete:hover {
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
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px; position: sticky; top: 0; height: 100vh;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}" class="active">📚 Book Management</a>
        <a href="{{ route('admin.borrowings.index') }}">📋 Borrowing Management</a>
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
            <h2>Book Catalog Management</h2>
            <a href="{{ route('books.create') }}" class="btn-add-book">+ Add New Book</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Books Table -->
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Info Buku</th>
                            <th>Penerbit</th>
                            <th>Kategori</th>
                            <th>Bahasa</th>
                            <th>Stok</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $book->title }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Oleh: {{ $book->author }}</div>
                            </td>
                            <td>
                                <div>{{ $book->publisher }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">Tahun: {{ $book->year }}</div>
                            </td>
                            <td>
                                @if($book->category)
                                    <span class="badge-status badge-neutral">{{ $book->category }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $book->language ?? '-' }}</td>
                            <td>
                                @if($book->stock > 0)
                                    <span class="badge-status badge-instock">🟢 {{ $book->stock }} Tersedia</span>
                                @else
                                    <span class="badge-status badge-outofstock">🔴 Habis</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('books.edit', $book->id) }}" class="action-btn btn-edit">✏️ Edit</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini dari katalog?')">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div style="font-size: 3rem; margin-bottom: 12px;">📚</div>
                                <h5>Belum ada buku di katalog</h5>
                                <p class="mb-0" style="font-size: 0.9rem;">Silakan tambahkan buku baru untuk mengisi katalog perpustakaan.</p>
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