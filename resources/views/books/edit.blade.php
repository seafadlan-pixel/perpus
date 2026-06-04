<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .sidebar { background: #0f172a; min-height: 100vh; color: white; padding-top: 24px; box-shadow: 1px 0 0 #e2e8f0; }
        .sidebar h4 { font-size: 1.1rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em; opacity: 0.95; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 12px 24px; display: block; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .main-content { padding: 40px; }
        .card { border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); background-color: #ffffff; }
        
        .form-label { font-weight: 500; color: #475569; font-size: 0.875rem; }
        .form-control { border-color: #e2e8f0; border-radius: 8px; padding: 10px 14px; font-size: 0.9rem; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08); border-color: #0f172a; }
        
        .btn-save {
            background: #0f172a;
            color: white;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 10px 20px;
            border: 1px solid #0f172a;
            transition: all 0.15s;
        }
        .btn-save:hover {
            background: #1e293b;
            border-color: #1e293b;
            color: white;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            padding: 10px 20px;
            border: 1px solid #e2e8f0;
            transition: all 0.15s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cancel:hover {
            background: #e2e8f0;
            color: #334155;
        }
        
        .btn-back {
            background: #ffffff;
            color: #475569;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            padding: 6px 12px;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            display: inline-block;
            transition: all 0.15s;
        }
        .btn-back:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}" class="active">📚 Book Management</a>
        <a href="{{ route('admin.borrowings.index') }}">📋 Borrowing Management</a>
        <a href="{{ route('admin.users.index') }}">👥 Member List</a>
        <a href="{{ route('public.index') }}">🌍 View Public Site</a>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto px-3 pb-4" style="position: absolute; bottom: 0; width: 250px;">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Book: {{ $book->title }}</h2>
            <a href="{{ route('books.index') }}" class="btn-back">&larr; Back to Catalog</a>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ $book->title }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Author *</label>
                            <input type="text" name="author" class="form-control" value="{{ $book->author }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Publisher *</label>
                            <input type="text" name="publisher" class="form-control" value="{{ $book->publisher }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Publication Year *</label>
                            <input type="number" name="year" class="form-control" value="{{ $book->year }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock *</label>
                            <input type="number" name="stock" class="form-control" value="{{ $book->stock }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Category</label>
                            <input type="text" name="category" class="form-control" value="{{ $book->category }}" placeholder="Contoh: Fiksi, Sains, Sejarah">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Language</label>
                            <input type="text" name="language" class="form-control" value="{{ $book->language }}" placeholder="Contoh: Indonesia, Inggris">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="{{ $book->isbn }}" placeholder="Masukkan kode ISBN jika ada">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cover Image URL</label>
                        <input type="url" name="cover_image" class="form-control" value="{{ $book->cover_image }}" placeholder="https://example.com/image.jpg">
                        <small class="text-muted" style="font-size: 0.75rem;">Masukkan URL gambar sampul buku (opsional).</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Synopsis</label>
                        <textarea name="synopsis" class="form-control" rows="5" placeholder="Tuliskan sinopsis singkat mengenai buku...">{{ $book->synopsis }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn-save">💾 Update Book</button>
                        <a href="{{ route('books.index') }}" class="btn-cancel">Batal</a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
