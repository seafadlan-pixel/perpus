<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Lentera Pustaka</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-weight: 700;
            color: #2a5298 !important;
        }
        .book-detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-top: 100px;
            margin-bottom: 50px;
        }
        .book-cover-large {
            width: 100%;
            height: 500px;
            object-fit: cover;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5rem;
            color: #aaa;
        }
        .detail-content {
            padding: 40px;
        }
        .badge-category {
            background-color: #2a5298;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .book-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        .book-author {
            font-size: 1.2rem;
            color: #6c757d;
            margin-bottom: 25px;
        }
        .meta-list {
            list-style: none;
            padding: 0;
            margin: 0 0 30px 0;
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }
        .meta-list li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .meta-list li:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .meta-label {
            font-weight: 600;
            color: #555;
        }
        .synopsis-title {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        .synopsis-content {
            line-height: 1.8;
            color: #444;
            font-size: 1.1rem;
        }

        /* Responsive Media Queries */
        @media (max-width: 768px) {
            .book-cover-large {
                height: 320px !important;
            }
            .detail-content {
                padding: 24px !important;
            }
            .book-title {
                font-size: 1.8rem !important;
                margin-top: 10px !important;
            }
            .book-detail-card {
                margin-top: 80px !important;
                margin-bottom: 30px !important;
                border-radius: 12px !important;
            }
        }
        @media (max-width: 576px) {
            .navbar button span {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.index') }}">
                🌎 Lentera Pustaka
            </a>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('public.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">← Katalog</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/books" class="btn btn-outline-dark btn-sm rounded-3 px-3">Library Admin</a>
                    @else
                        <a href="{{ route('borrow.my') }}" class="btn btn-outline-dark btn-sm rounded-3 px-3">📋 Peminjaman</a>
                    @endif
                    <!-- Dropdown Profil -->
                    <div class="dropdown">
                        <button class="btn btn-link p-0 border-0 dropdown-toggle d-flex align-items-center gap-2 text-decoration-none" type="button" data-bs-toggle="dropdown" style="color: #0f172a;">
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f172a&color=ffffff&size=80&rounded=true&bold=true"
                                alt="{{ auth()->user()->name }}"
                                style="width: 34px; height: 34px; border-radius: 50%; border: 2px solid #e2e8f0;"
                            >
                            <span style="font-size: 0.875rem; font-weight: 500; color: #0f172a;">{{ auth()->user()->name }}</span>
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
                                <li><a class="dropdown-item py-2" href="{{ route('borrow.my') }}" style="font-size: 0.875rem;">📋 Peminjaman Saya</a></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger" style="font-size: 0.875rem;">🚶 Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm rounded-3 px-3">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="book-detail-card row g-0">
            <div class="col-md-5">
                @if($book->cover_image)
                    <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="book-cover-large">
                @else
                    <div class="book-cover-large">📚</div>
                @endif
            </div>
            <div class="col-md-7">
                <div class="detail-content">
                    @if($book->category)
                        <span class="badge badge-category">{{ $book->category }}</span>
                    @endif
                    
                    <h1 class="book-title">{{ $book->title }}</h1>
                    <div class="book-author">by {{ $book->author }}</div>
                    
                    <ul class="meta-list">
                        <li><span class="meta-label">Language</span> <span>{{ $book->language ?? 'Not specified' }}</span></li>
                        <li><span class="meta-label">ISBN</span> <span>{{ $book->isbn ?? 'Not available' }}</span></li>
                        <li><span class="meta-label">Publisher</span> <span>{{ $book->publisher }}</span></li>
                        <li><span class="meta-label">Publication Year</span> <span>{{ $book->year }}</span></li>
                        <li><span class="meta-label">Available Stock</span> 
                            <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $book->stock > 0 ? $book->stock . ' copies' : 'Out of stock' }}
                            </span>
                        </li>
                    </ul>

                    <h3 class="synopsis-title">Synopsis</h3>
                    <div class="synopsis-content">
                        @if($book->synopsis)
                            {!! nl2br(e($book->synopsis)) !!}
                        @else
                            <p class="text-muted fst-italic">No synopsis available for this book.</p>
                        @endif
                    </div>

                    @auth
                        @if(session('error'))
                            <div class="alert alert-danger mt-3" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success mt-3" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mt-4 pt-3" style="border-top: 2px solid #e9ecef;">
                            @if(auth()->user()->role !== 'admin')
                                @if($book->stock > 0)
                                    <a href="{{ route('borrow.create', $book->id) }}" class="btn btn-lg btn-dark rounded-pill px-5 py-3" style="font-weight: 600;">
                                        📥 Pinjam Buku Ini
                                    </a>
                                @else
                                    <button class="btn btn-lg btn-secondary rounded-pill px-5 py-3" disabled style="font-weight: 600;">
                                        📛 Stok Habis
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('admin.borrowings.create') }}?book_id={{ $book->id }}"
                                   class="btn btn-lg btn-dark rounded-pill px-5 py-3"
                                   style="font-weight: 600;">
                                    ⚡ Pinjamkan Buku ke Member
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
