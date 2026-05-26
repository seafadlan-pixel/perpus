<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Book Management</title>
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
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Book Catalog Management</h2>
            <a href="{{ route('books.create') }}" class="btn btn-primary">+ Add New Book</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Language</th>
                            <th>Stock</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $book)
                        <tr>
                            <td class="ps-4">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td><span class="badge bg-secondary">{{ $book->category ?? '-' }}</span></td>
                            <td>{{ $book->language ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $book->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $book->stock }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No books found in the catalog.</td>
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