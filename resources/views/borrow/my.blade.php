<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya - Lentera Pustaka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
            min-height: 100vh;
        }

        .navbar {
            background-color: #ffffff !important;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            color: #0f172a !important;
            letter-spacing: -0.02em;
        }

        .main-container {
            max-width: 960px;
            margin: 110px auto 60px;
            padding: 0 24px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .page-header p {
            color: #64748b;
            font-size: 0.925rem;
            margin: 0;
        }

        .borrowing-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #fafafa;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 20px;
        }

        .table tbody td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            color: #334155;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .book-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .book-thumb {
            width: 36px;
            height: 50px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            background-color: #f1f5f9;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .book-cell-info .book-cell-title {
            font-weight: 600;
            color: #0f172a;
            font-size: 0.875rem;
            letter-spacing: -0.01em;
        }

        .book-cell-info .book-cell-author {
            color: #64748b;
            font-size: 0.75rem;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }

        .badge-pending {
            background-color: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .badge-approved {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .badge-returned {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
        }

        .badge-rejected {
            background-color: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .date-cell {
            font-size: 0.85rem;
            color: #475569;
        }

        .date-cell small {
            display: block;
            color: #94a3b8;
            font-size: 0.75rem;
            margin-top: 2px;
        }

        .empty-state {
            text-align: center;
            padding: 72px 24px;
        }

        .empty-state-icon {
            font-size: 2.8rem;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 6px;
            font-size: 1.15rem;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 24px;
            font-size: 0.9rem;
        }

        .btn-browse {
            background: #0f172a;
            color: #ffffff;
            border: 1px solid #0f172a;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .btn-browse:hover {
            background: #1e293b;
            color: #ffffff;
            border-color: #1e293b;
        }

        .overdue {
            color: #dc2626;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.index') }}">
                📚 Lentera Pustaka
            </a>
            <div class="d-flex align-items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/books" class="btn btn-outline-dark btn-sm rounded-3 px-3 me-3">Library Admin</a>
                    @endif
                    <a href="{{ route('borrow.my') }}" class="btn btn-outline-dark btn-sm rounded-3 px-3 me-3">📋 Peminjaman Saya</a>
                    <span class="me-3 text-secondary" style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-dark rounded-3 px-3">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="page-header">
            <div>
                <h1>📋 Peminjaman Saya</h1>
                <p>Daftar semua buku yang kamu pinjam</p>
            </div>
            <a href="{{ route('public.index') }}" class="btn btn-browse">📚 Jelajahi Buku</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="borrowing-card">
            @if($borrowings->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Dikembalikan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowings as $borrowing)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="book-cell">
                                    <div class="book-thumb" style="{{ $borrowing->book->cover_image ? 'background-image: url(' . $borrowing->book->cover_image . ')' : '' }}">
                                        @if(!$borrowing->book->cover_image)
                                            📖
                                        @endif
                                    </div>
                                    <div class="book-cell-info">
                                        <div class="book-cell-title">{{ $borrowing->book->title }}</div>
                                        <div class="book-cell-author">{{ $borrowing->book->author }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="date-cell">
                                {{ $borrowing->borrow_date->format('d M Y') }}
                            </td>
                            <td class="date-cell">
                                {{ $borrowing->due_date->format('d M Y') }}
                                @if($borrowing->status === 'approved' && $borrowing->due_date->isPast())
                                    <small class="overdue">⚠️ Terlambat</small>
                                @endif
                            </td>
                            <td class="date-cell">
                                @if($borrowing->return_date)
                                    {{ $borrowing->return_date->format('d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($borrowing->status)
                                    @case('pending')
                                        <span class="badge-status badge-pending">⏳ Menunggu</span>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📚</div>
                    <h3>Belum ada peminjaman</h3>
                    <p>Kamu belum meminjam buku apapun. Yuk mulai jelajahi koleksi kami!</p>
                    <a href="{{ route('public.index') }}" class="btn btn-browse">Jelajahi Buku</a>
                </div>
            @endif
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
