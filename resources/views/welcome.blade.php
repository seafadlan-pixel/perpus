<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lentera Pustaka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fafafa;
            color: #1e293b;
        }
        
        .hero-section {
            background-color: #ffffff;
            padding: 80px 0 60px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 40px;
        }
        
        .hero-title {
            font-weight: 700;
            font-size: 2.75rem;
            color: #0f172a;
            margin-bottom: 16px;
            letter-spacing: -0.025em;
        }
        
        .hero-subtitle {
            color: #64748b;
            font-size: 1.125rem;
            margin-bottom: 40px;
            font-weight: 400;
        }
        
        .search-bar {
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-bar input {
            border-radius: 8px;
            padding: 14px 20px;
            border: 1px solid #cbd5e1;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            font-size: 1rem;
        }
        
        .search-bar input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .search-bar button {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            border-radius: 6px;
            padding: 0 20px;
            background-color: #0f172a;
            border: none;
            color: white;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .search-bar button:hover {
            background-color: #334155;
        }

        .filter-section {
            margin-bottom: 30px;
        }
        
        .filter-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            background-color: #ffffff;
            color: #475569;
            text-decoration: none;
            margin: 4px;
            border: 1px solid #e2e8f0;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }
        
        .filter-badge:hover, .filter-badge.active {
            background-color: #0f172a;
            color: white;
            border-color: #0f172a;
        }

        .book-card {
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            height: 100%;
            background: white;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        
        .book-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }
        
        .book-cover {
            height: 220px;
            background-color: #f8fafc;
            background-size: cover;
            background-position: center;
            border-bottom: 1px solid #f1f5f9;
            position: relative;
        }
        
        .category-tag {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.9);
            color: #0f172a;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .book-info {
            padding: 16px;
        }
        
        .book-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 4px;
            color: #0f172a;
        }
        
        .book-author {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 12px;
        }
        
        .navbar {
            background-color: rgba(255, 255, 255, 0.98) !important;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #0f172a !important;
        }

        /* Overdue Warning Modal */
        .overdue-modal-backdrop {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
        }
        .overdue-modal {
            background: #fff;
            border-radius: 18px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            overflow: hidden;
            animation: modalSlideIn 0.35s cubic-bezier(.4,0,.2,1);
        }
        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(-24px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .overdue-modal-header {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            padding: 24px 28px 20px;
            color: white;
        }
        .overdue-modal-header h4 { font-size: 1.1rem; font-weight: 700; margin: 0; }
        .overdue-modal-header p  { font-size: 0.85rem; margin: 6px 0 0; opacity: 0.9; }
        .overdue-modal-body { padding: 20px 28px; }
        .overdue-book-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 12px 14px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .overdue-book-item:last-child { margin-bottom: 0; }
        .overdue-icon { font-size: 1.5rem; flex-shrink: 0; line-height: 1; margin-top: 2px; }
        .overdue-book-title { font-weight: 600; color: #0f172a; font-size: 0.9rem; }
        .overdue-book-meta { font-size: 0.8rem; color: #64748b; margin-top: 2px; }
        .overdue-fine { font-size: 0.82rem; font-weight: 600; color: #dc2626; margin-top: 4px; }
        .overdue-total-box {
            background: #1e293b;
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 16px;
            display: flex; justify-content: space-between; align-items: center;
        }
        .overdue-total-box span:first-child { color: #94a3b8; font-size: 0.85rem; }
        .overdue-total-box span:last-child  { color: #f87171; font-size: 1.1rem; font-weight: 700; }
        .overdue-modal-footer { padding: 16px 28px 24px; text-align: center; }
        .btn-overdue-close {
            background: #dc2626; color: white; border: none;
            padding: 10px 32px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
            cursor: pointer; transition: background 0.15s;
        }
        .btn-overdue-close:hover { background: #b91c1c; }
        .btn-overdue-secondary {
            background: none; border: 1px solid #e2e8f0; color: #64748b;
            padding: 10px 20px; border-radius: 8px; font-weight: 500; font-size: 0.85rem;
            cursor: pointer; transition: all 0.15s; margin-right: 8px;
            text-decoration: none; display: inline-block;
        }
        .btn-overdue-secondary:hover { background: #f8fafc; color: #334155; }

        /* Recommendation Section Premium Styling */
        .recommendation-container {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .recommendation-container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .recommendation-container::after {
            content: '';
            position: absolute;
            bottom: -50%;
            left: -20%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.08) 0%, rgba(255, 255, 255, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .badge-recom {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 50px;
            letter-spacing: 0.05em;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }

        .recommendation-title {
            font-weight: 800;
            font-size: 1.75rem;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .recommendation-subtitle {
            font-size: 0.95rem;
        }

        .recom-card {
            display: block;
            text-decoration: none;
            color: inherit;
            height: 100%;
            border-radius: 16px;
            overflow: hidden;
            background: white;
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .recom-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #e2e8f0;
        }

        .recom-card-inner {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .recom-cover-wrapper {
            position: relative;
            padding-top: 60%; /* 5:3 Aspect Ratio */
            overflow: hidden;
            background-color: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }

        .recom-cover {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.5s ease;
        }

        .recom-card:hover .recom-cover {
            transform: scale(1.06);
        }

        .recom-category {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(4px);
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .recom-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .recom-title {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 6px;
            color: #0f172a;
            transition: color 0.2s ease;
        }

        .recom-card:hover .recom-title {
            color: #4f46e5;
        }

        .recom-author {
            color: #64748b;
            font-size: 0.88rem;
        }

        .recom-btn {
            margin-top: auto;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4f46e5;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .recom-card:hover .recom-btn {
            color: #3730a3;
        }

        /* Responsive Media Queries */
        @media (max-width: 768px) {
            .hero-section {
                padding: 50px 0 40px !important;
                margin-bottom: 20px !important;
            }
            .hero-title {
                font-size: 2rem !important;
            }
            .hero-subtitle {
                font-size: 1rem !important;
                margin-bottom: 25px !important;
            }
            .recommendation-container {
                padding: 20px !important;
                border-radius: 18px !important;
            }
            .recommendation-title {
                font-size: 1.4rem !important;
            }
            .recommendation-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px !important;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem !important;
            }
            .navbar .btn-sm {
                padding: 6px 10px !important;
                font-size: 0.75rem !important;
            }
            /* Hide username text on mobile to save space */
            .navbar button span {
                display: none !important;
            }
            .filter-badge {
                padding: 5px 12px !important;
                font-size: 0.8rem !important;
            }
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
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/books" class="btn btn-outline-dark btn-sm rounded-3 px-3">Library Admin</a>
                    @else
                        <a href="{{ route('borrow.my') }}" class="btn btn-outline-dark btn-sm rounded-3 px-3">📋 Peminjaman Saya</a>
                    @endif

                    <!-- User Profile Dropdown -->
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
                            @if(auth()->user()->role !== 'admin')
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('borrow.my') }}" style="font-size: 0.875rem;">📋 Peminjaman Saya</a>
                                </li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger" style="font-size: 0.875rem;">🚪 Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm rounded-3 px-3">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-dark btn-sm rounded-3 px-3">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="hero-section" style="margin-top: 56px;">
        <div class="container">
            <h1 class="hero-title">Temukan Bacaan Favoritmu!</h1>
            <p class="hero-subtitle">Jelajahi ribuan koleksi dan temukan bacaan favoritmu.</p>
            
            <form action="{{ route('public.index') }}" method="GET" class="search-bar">
                <input type="text" name="search" class="form-control" placeholder="Search by title, author, or category..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="container mb-5">
        
        @if(Auth::check() && isset($recommendedBooks) && $recommendedBooks->count() > 0)
            <!-- Section Rekomendasi Buku Hari Ini -->
            <div class="recommendation-container mb-5">
                <div class="recommendation-header d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <span class="badge-recom">✨ PILIHAN HARI INI</span>
                        <h2 class="recommendation-title mt-2 mb-1">Rekomendasi Spesial Untukmu</h2>
                        <p class="recommendation-subtitle text-muted mb-0">Tiga buku pilihan yang dikurasi khusus untuk dibaca hari ini.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <span class="text-muted" style="font-size: 0.85rem;"><i class="bi bi-info-circle"></i> Rekomendasi akan berganti setiap login</span>
                    </div>
                </div>

                <div class="row g-4">
                    @foreach($recommendedBooks as $recomBook)
                        <div class="col-md-4">
                            <a href="{{ route('public.show', $recomBook->id) }}" class="recom-card">
                                <div class="recom-card-inner">
                                    <div class="recom-cover-wrapper">
                                        <div class="recom-cover" style="background-image: url('{{ $recomBook->cover_image }}');">
                                            @if(!$recomBook->cover_image)
                                                <div class="d-flex align-items-center justify-content-center h-100 text-muted fs-2">📖</div>
                                            @endif
                                        </div>
                                        @if($recomBook->category)
                                            <span class="recom-category">{{ $recomBook->category }}</span>
                                        @endif
                                    </div>
                                    <div class="recom-info">
                                        <h3 class="recom-title text-truncate">{{ $recomBook->title }}</h3>
                                        <div class="recom-author text-truncate">Oleh {{ $recomBook->author }}</div>
                                        <div class="recom-btn mt-3">Lihat Buku &nbsp;→</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="filter-section text-center">
            <a href="{{ route('public.index') }}" class="filter-badge {{ !request('category') ? 'active' : '' }}">All</a>
            @foreach($categories as $category)
                <a href="{{ route('public.index', ['category' => $category]) }}" class="filter-badge {{ request('category') == $category ? 'active' : '' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse ($books as $book)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('public.show', $book->id) }}" class="book-card">
                        <div class="book-cover" style="background-image: url('{{ $book->cover_image }}');">
                            @if(!$book->cover_image)
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted fs-1">📖</div>
                            @endif
                            @if($book->category)
                                <span class="category-tag">{{ $book->category }}</span>
                            @endif
                        </div>
                        <div class="book-info">
                            <h3 class="book-title text-truncate">{{ $book->title }}</h3>
                            <div class="book-author text-truncate">by {{ $book->author }}</div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted mb-2">No books found</h4>
                    <p class="text-muted" style="font-size: 0.9rem;">Try adjusting your search or filters.</p>
                </div>
            @endforelse
        </div>
        
        <div class="d-flex justify-content-center mt-5">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>

    </div>

@if(Auth::check() && Auth::user()->role === 'visitor' && $overdueWarnings->count() > 0)
<!-- ⚠️ Overdue Warning Modal -->
<div class="overdue-modal-backdrop" id="overdueModalBackdrop">
    <div class="overdue-modal" role="alertdialog" aria-modal="true" aria-labelledby="overdueTitle">

        <div class="overdue-modal-header">
            <div style="font-size: 2rem; margin-bottom: 8px;">⏰</div>
            <h4 id="overdueTitle">Buku Terlambat Dikembalikan!</h4>
            <p>Kamu memiliki {{ $overdueWarnings->count() }} buku yang melewati batas waktu peminjaman. Denda terus bertambah setiap hari.</p>
        </div>

        <div class="overdue-modal-body">
            @foreach($overdueWarnings as $item)
            <div class="overdue-book-item">
                <div class="overdue-icon">📕</div>
                <div>
                    <div class="overdue-book-title">{{ $item['title'] }}</div>
                    <div class="overdue-book-meta">Jatuh tempo: {{ $item['due_date'] }} &nbsp;·&nbsp; <strong style="color: #dc2626;">{{ $item['days_late'] }} hari terlambat</strong></div>
                    <div class="overdue-fine">💰 Denda saat ini: Rp {{ number_format($item['fine'], 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach

            @php $totalFineOverdue = $overdueWarnings->sum('fine'); @endphp
            <div class="overdue-total-box">
                <span>Total denda terkumulasi</span>
                <span>Rp {{ number_format($totalFineOverdue, 0, ',', '.') }}</span>
            </div>

            <div style="font-size: 0.78rem; color: #94a3b8; margin-top: 12px; text-align: center; line-height: 1.5;">
                Denda dihitung otomatis Rp 2.000/hari sejak tanggal jatuh tempo.<br>
                Segera kembalikan buku ke perpustakaan.
            </div>
        </div>

        <div class="overdue-modal-footer">
            <a href="{{ route('borrow.my') }}" class="btn-overdue-secondary">📋 Lihat Peminjaman</a>
            <button class="btn-overdue-close" onclick="closeOverdueModal()">Saya Mengerti</button>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function closeOverdueModal() {
        const backdrop = document.getElementById('overdueModalBackdrop');
        if (backdrop) {
            backdrop.style.opacity = '0';
            backdrop.style.transition = 'opacity 0.25s';
            setTimeout(() => backdrop.remove(), 260);
        }
    }
    // Tutup modal saat klik di luar kotak
    const overdueBackdrop = document.getElementById('overdueModalBackdrop');
    if (overdueBackdrop) {
        overdueBackdrop.addEventListener('click', function(e) {
            if (e.target === this) closeOverdueModal();
        });
    }
</script>
</body>
</html>
