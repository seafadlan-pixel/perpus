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
            <h1 class="hero-title">Discover Your Next Read</h1>
            <p class="hero-subtitle">Explore our curated collection of international literature.</p>
            
            <form action="{{ route('public.index') }}" method="GET" class="search-bar">
                <input type="text" name="search" class="form-control" placeholder="Search by title, author, or category..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="container mb-5">
        
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
