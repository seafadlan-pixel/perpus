<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International Library</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
            border-bottom-left-radius: 50px;
            border-bottom-right-radius: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 50px;
        }
        
        .hero-title {
            font-weight: 700;
            font-size: 3rem;
            margin-bottom: 20px;
        }
        
        .search-bar {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-bar input {
            border-radius: 30px;
            padding: 15px 25px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            font-size: 1.1rem;
        }
        
        .search-bar button {
            position: absolute;
            right: 5px;
            top: 5px;
            border-radius: 25px;
            padding: 10px 30px;
            background-color: #ff6b6b;
            border: none;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .search-bar button:hover {
            background-color: #ff5252;
            transform: translateY(-2px);
        }

        /* Filter Section */
        .filter-section {
            margin-bottom: 40px;
        }
        
        .filter-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            background-color: #fff;
            color: #555;
            text-decoration: none;
            margin: 5px;
            border: 1px solid #ddd;
            transition: all 0.2s ease;
        }
        
        .filter-badge:hover, .filter-badge.active {
            background-color: #2a5298;
            color: white;
            border-color: #2a5298;
        }

        /* Book Cards */
        .book-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            background: white;
            text-decoration: none;
            display: block;
            color: inherit;
        }
        
        .book-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .book-cover {
            height: 250px;
            background-color: #e9ecef;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .book-cover-placeholder {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
            font-size: 3rem;
        }
        
        .category-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(42, 82, 152, 0.9);
            color: white;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .book-info {
            padding: 20px;
        }
        
        .book-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .book-author {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .book-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #2a5298 !important;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.index') }}">
                🌎 International Library
            </a>
            <div class="d-flex align-items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/books" class="btn btn-outline-primary rounded-pill px-4 me-2">Dashboard</a>
                    @endif
                    <span class="me-3 fw-bold text-secondary">{{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section" style="margin-top: 56px;">
        <div class="container">
            <h1 class="hero-title">Discover Your Next Great Read</h1>
            <p class="lead mb-4">Explore our vast collection of international literature.</p>
            
            <form action="{{ route('public.index') }}" method="GET" class="search-bar">
                <input type="text" name="search" class="form-control" placeholder="Search by title, author, or category..." value="{{ request('search') }}">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <div class="container mb-5">
        
        <!-- Filters -->
        <div class="filter-section text-center">
            <a href="{{ route('public.index') }}" class="filter-badge {{ !request('category') ? 'active' : '' }}">All Categories</a>
            @foreach($categories as $category)
                <a href="{{ route('public.index', ['category' => $category]) }}" class="filter-badge {{ request('category') == $category ? 'active' : '' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        <!-- Books Grid -->
        <div class="row g-4">
            @forelse ($books as $book)
                <div class="col-md-4 col-lg-3">
                    <a href="{{ route('public.show', $book->id) }}" class="book-card">
                        <div class="book-cover" style="background-image: url('{{ $book->cover_image }}');">
                            @if(!$book->cover_image)
                                <div class="book-cover-placeholder">📚</div>
                            @endif
                            @if($book->category)
                                <span class="category-tag">{{ $book->category }}</span>
                            @endif
                        </div>
                        <div class="book-info">
                            <h3 class="book-title">{{ $book->title }}</h3>
                            <div class="book-author">by {{ $book->author }}</div>
                            <div class="book-meta">
                                <span><i class="bi bi-globe"></i> {{ $book->language ?? 'N/A' }}</span>
                                <span>{{ $book->year }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="display-1 text-muted mb-3">📭</div>
                    <h3>No books found</h3>
                    <p class="text-muted">Try adjusting your search or filters.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} International Library. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
