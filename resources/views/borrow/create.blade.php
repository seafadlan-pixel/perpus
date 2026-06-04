<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku - {{ $book->title }}</title>
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

        .borrow-container {
            max-width: 760px;
            margin: 110px auto 60px;
            padding: 0 24px;
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .page-header p {
            color: #64748b;
            font-size: 0.925rem;
            margin-bottom: 0;
        }

        .borrow-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .book-summary {
            background: #fafafa;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .book-summary-cover {
            width: 64px;
            height: 88px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            background-size: cover;
            background-position: center;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .book-summary-info h3 {
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 4px;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .book-summary-info p {
            color: #64748b;
            margin-bottom: 0;
            font-size: 0.85rem;
        }

        .book-summary-stock {
            margin-left: auto;
            text-align: center;
            border-left: 1px solid #e2e8f0;
            padding-left: 24px;
        }

        .stock-number {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
        }

        .stock-label {
            font-size: 0.65rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .form-section {
            padding: 32px;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f1f5f9;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-control {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            color: #1e293b;
            background-color: #ffffff;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-control:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 1px #0f172a;
            outline: none;
        }

        .form-text {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        .btn-submit {
            background: #0f172a;
            border: 1px solid #0f172a;
            color: #ffffff;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.15s ease;
        }

        .btn-submit:hover {
            background: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
        }

        .btn-cancel {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.15s ease;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .required-star {
            color: #ef4444;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.index') }}">
                📚 Lentera Pustaka
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('public.show', $book->id) }}" class="btn btn-outline-dark btn-sm rounded-3 px-3">← Kembali ke Detail</a>
                @auth
                    <!-- Dropdown Profil -->
                    <div class="dropdown">
                        <button class="btn btn-link p-0 border-0 dropdown-toggle d-flex align-items-center gap-2 text-decoration-none" type="button" data-bs-toggle="dropdown" style="color: #0f172a;">
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f172a&color=ffffff&size=80&rounded=true&bold=true"
                                alt="{{ auth()->user()->name }}"
                                style="width: 34px; height: 34px; border-radius: 50%; border: 2px solid #e2e8f0;"
                            >
                            <span style="font-size: 0.875rem; font-weight: 500;">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius: 10px; min-width: 200px; margin-top: 8px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-semibold" style="font-size: 0.875rem;">{{ auth()->user()->name }}</div>
                                <div class="text-muted" style="font-size: 0.78rem;">{{ auth()->user()->email }}</div>
                                @if(auth()->user()->class)
                                    <div class="text-muted" style="font-size: 0.78rem;">🏫 {{ auth()->user()->class }}</div>
                                @endif
                            </li>
                            <li><a class="dropdown-item py-2" href="{{ route('borrow.my') }}" style="font-size: 0.875rem;">📋 Peminjaman Saya</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger" style="font-size: 0.875rem;">🚪 Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </nav>


    <div class="borrow-container">
        <div class="page-header">
            <h1>📋 Form Peminjaman Buku</h1>
            <p>Isi data peminjaman di bawah ini. Peminjaman akan diproses setelah disetujui oleh admin.</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="borrow-card">
            <!-- Book Summary -->
            <div class="book-summary">
                <div class="book-summary-cover" style="{{ $book->cover_image ? 'background-image: url(' . $book->cover_image . ')' : '' }}">
                    @if(!$book->cover_image)
                        📖
                    @endif
                </div>
                <div class="book-summary-info">
                    <h3>{{ $book->title }}</h3>
                    <p>oleh {{ $book->author }}</p>
                    <p>{{ $book->publisher }} · {{ $book->year }}</p>
                </div>
                <div class="book-summary-stock">
                    <div class="stock-number">{{ $book->stock }}</div>
                    <div class="stock-label">Stok Tersedia</div>
                </div>
            </div>

            <!-- Borrowing Form -->
            <form action="{{ route('borrow.store') }}" method="POST" class="form-section">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">

                <h5 class="section-title">📌 Data Peminjam</h5>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="borrower_name" class="form-label">Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="borrower_name" name="borrower_name" value="{{ old('borrower_name', auth()->user()->name) }}" required placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="col-md-6">
                        <label for="borrower_phone" class="form-label">No. Telepon <span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="borrower_phone" name="borrower_phone" value="{{ old('borrower_phone') }}" required placeholder="contoh: 08123456789">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="borrower_address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="borrower_address" name="borrower_address" rows="2" placeholder="Masukkan alamat (opsional)">{{ old('borrower_address') }}</textarea>
                </div>

                <h5 class="section-title">📅 Detail Peminjaman</h5>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label for="borrow_date" class="form-label">Tanggal Pinjam <span class="required-star">*</span></label>
                        <input type="date" class="form-control" id="borrow_date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="duration" class="form-label">Durasi Pinjam (hari) <span class="required-star">*</span></label>
                        <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', 7) }}" min="1" max="30" required>
                        <div class="form-text">Minimal 1 hari, maksimal 30 hari</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label">Catatan Tambahan</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Catatan untuk admin (opsional)">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex gap-3 justify-content-end pt-3" style="border-top: 1px solid #f1f5f9;">
                    <a href="{{ route('public.show', $book->id) }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-submit">📤 Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
