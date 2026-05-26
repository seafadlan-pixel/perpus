<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f6f9; }
        .sidebar { background: #343a40; min-height: 100vh; color: white; padding-top: 20px;}
        .sidebar a { color: #cfd8dc; text-decoration: none; padding: 10px 20px; display: block; }
        .sidebar a:hover { background: #495057; color: white; }
        .main-content { padding: 30px; }
        .card { border: none; box-shadow: 0 0 15px rgba(0,0,0,0.05); border-radius: 10px; }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}">📚 Book Management</a>
        <a href="{{ route('public.index') }}" target="_blank">🌍 View Public Site</a>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto px-3 pb-4" style="position: absolute; bottom: 0; width: 250px;">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
        
        <div class="mb-4">
            <h2>Edit Book: {{ $book->title }}</h2>
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Catalog</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Author *</label>
                            <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Publisher *</label>
                            <input type="text" name="publisher" class="form-control" value="{{ $book->publisher }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Publication Year *</label>
                            <input type="number" name="year" class="form-control" value="{{ $book->year }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Stock *</label>
                            <input type="number" name="stock" class="form-control" value="{{ $book->stock }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <input type="text" name="category" class="form-control" value="{{ $book->category }}" placeholder="e.g. Fiction, Science, History">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Language</label>
                            <input type="text" name="language" class="form-control" value="{{ $book->language }}" placeholder="e.g. English, Indonesian">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ $book->isbn }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cover Image URL</label>
                        <input type="url" name="cover_image" class="form-control" value="{{ $book->cover_image }}" placeholder="https://example.com/image.jpg">
                        <small class="text-muted">Provide a direct link to an image for the book cover.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Synopsis</label>
                        <textarea name="synopsis" class="form-control" rows="5">{{ $book->synopsis }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">Update Book</button>
                    <a href="{{ route('books.index') }}" class="btn btn-light px-4 ms-2">Cancel</a>

                </form>
            </div>
        </div>

    </div>
</div>

</body>
</html>
