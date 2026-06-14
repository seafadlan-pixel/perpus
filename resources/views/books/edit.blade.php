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
        .sidebar { background: #0f172a; min-height: 100vh; color: white; padding-top: 24px; box-shadow: 1px 0 0 #e2e8f0; display: flex; flex-direction: column; width: 250px; min-width: 250px; flex-shrink: 0; }
        .sidebar h4 { font-size: 1.1rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em; opacity: 0.95; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 12px 24px; display: block; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; white-space: nowrap; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .main-content { padding: 40px; }
        .card { border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); background-color: #ffffff; }
        
        .form-label { font-weight: 500; color: #475569; font-size: 0.875rem; }
        .form-control { border-color: #e2e8f0; border-radius: 8px; padding: 10px 14px; font-size: 0.9rem; }
        .form-control:focus { box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08); border-color: #0f172a; }
        
        .btn-save { background: #0f172a; color: white; border-radius: 6px; font-size: 0.875rem; font-weight: 500; padding: 10px 20px; border: 1px solid #0f172a; transition: all 0.15s; }
        .btn-save:hover { background: #1e293b; border-color: #1e293b; color: white; }
        .btn-cancel { background: #f1f5f9; color: #475569; border-radius: 6px; font-size: 0.875rem; font-weight: 500; padding: 10px 20px; border: 1px solid #e2e8f0; transition: all 0.15s; text-decoration: none; display: inline-block; }
        .btn-cancel:hover { background: #e2e8f0; color: #334155; }
        .btn-back { background: #ffffff; color: #475569; border-radius: 6px; font-size: 0.8rem; font-weight: 500; padding: 6px 12px; border: 1px solid #e2e8f0; text-decoration: none; display: inline-block; transition: all 0.15s; }
        .btn-back:hover { background: #f8fafc; color: #0f172a; border-color: #cbd5e1; }

        /* Cover Preview */
        .cover-wrapper { display: flex; gap: 16px; align-items: flex-start; }
        .cover-preview-box {
            flex-shrink: 0;
            width: 120px; height: 160px;
            border: 2px dashed #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            background: #f8fafc;
            display: flex; align-items: center; justify-content: center;
            transition: border-color 0.2s;
            position: relative;
        }
        .cover-preview-box.has-image { border-style: solid; border-color: #0f172a; }
        .cover-preview-box.error { border-color: #ef4444; }
        .cover-preview-box img { width: 100%; height: 100%; object-fit: cover; display: none; }
        .cover-preview-box img.visible { display: block; }
        .cover-placeholder { text-align: center; color: #94a3b8; font-size: 0.72rem; padding: 8px; line-height: 1.4; }
        .cover-placeholder span { font-size: 2rem; display: block; margin-bottom: 4px; }
        .cover-url-area { flex: 1; }
        .cover-hint { font-size: 0.75rem; color: #64748b; margin-top: 6px; line-height: 1.5; }
        .cover-hint code { background: #f1f5f9; padding: 1px 5px; border-radius: 4px; font-size: 0.72rem; color: #0f172a; }
        .url-status { font-size: 0.75rem; margin-top: 4px; min-height: 18px; }
        .url-status.ok { color: #16a34a; }
        .url-status.err { color: #ef4444; }
        .btn-clear-url { font-size: 0.75rem; color: #94a3b8; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline; }
        .btn-clear-url:hover { color: #ef4444; }

        /* Responsive Layout Media Queries */
        @media (max-width: 992px) {
            .d-flex {
                flex-direction: column !important;
            }
            .sidebar {
                width: 100% !important;
                height: auto !important;
                min-height: auto !important;
                position: relative !important;
                padding: 16px !important;
                flex-direction: row !important;
                flex-wrap: wrap !important;
                justify-content: space-between !important;
                align-items: center !important;
            }
            .sidebar h4 {
                margin-bottom: 0 !important;
                margin-right: 20px !important;
            }
            .sidebar .mt-auto {
                margin-top: 0 !important;
                padding: 0 !important;
                width: auto !important;
            }
            .sidebar form {
                display: inline-block !important;
            }
            .sidebar a {
                padding: 8px 12px !important;
                border-radius: 6px !important;
            }
            .main-content {
                padding: 20px !important;
            }
        }
        @media (max-width: 576px) {
            .sidebar {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .sidebar h4 {
                margin-bottom: 15px !important;
                text-align: center !important;
            }
            .sidebar a {
                text-align: center !important;
                margin-bottom: 4px !important;
            }
            .sidebar .mt-auto {
                width: 100% !important;
                margin-top: 10px !important;
            }
            .cover-wrapper {
                flex-direction: column !important;
                align-items: center !important;
                text-align: center !important;
            }
            .cover-preview-box {
                margin-bottom: 12px !important;
            }
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
                        <label class="form-label">🖼️ Sampul Buku</label>
                        <div class="cover-wrapper">
                            <!-- Preview Box -->
                            <div class="cover-preview-box" id="coverPreviewBox">
                                <img id="coverPreviewImg" src="" alt="Preview Sampul">
                                <div class="cover-placeholder" id="coverPlaceholder">
                                    <span>📖</span>
                                    Preview sampul
                                </div>
                            </div>
                            <!-- Input Area -->
                            <div class="cover-url-area">
                                <input
                                    type="text"
                                    name="cover_image"
                                    id="coverUrlInput"
                                    class="form-control"
                                    placeholder="Paste link gambar di sini..."
                                    value="{{ $book->cover_image }}"
                                    autocomplete="off"
                                >
                                <div class="url-status" id="coverUrlStatus"></div>
                                <div class="cover-hint">
                                    💡 <strong>Cara pakai:</strong> Buka Google Images → klik gambar → klik kanan → <code>Copy image address</code> → paste di sini.
                                    <br>Format yang didukung: <code>.jpg</code> <code>.jpeg</code> <code>.png</code> <code>.webp</code> <code>.gif</code>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn-clear-url" id="clearCoverBtn" style="display:none;">✕ Hapus gambar</button>
                                </div>
                            </div>
                        </div>
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
<script>
    const coverInput   = document.getElementById('coverUrlInput');
    const previewImg   = document.getElementById('coverPreviewImg');
    const previewBox   = document.getElementById('coverPreviewBox');
    const placeholder  = document.getElementById('coverPlaceholder');
    const statusEl     = document.getElementById('coverUrlStatus');
    const clearBtn     = document.getElementById('clearCoverBtn');

    function setPreview(url) {
        if (!url) { resetPreview(); return; }
        statusEl.textContent = '⏳ Memuat gambar...';
        statusEl.className   = 'url-status';
        previewImg.src = url;
    }

    function resetPreview() {
        previewImg.src = '';
        previewImg.classList.remove('visible');
        previewBox.classList.remove('has-image', 'error');
        placeholder.style.display = 'flex';
        statusEl.textContent = '';
        clearBtn.style.display = 'none';
    }

    previewImg.addEventListener('load', function () {
        if (!this.src || this.src === window.location.href) return;
        this.classList.add('visible');
        previewBox.classList.add('has-image');
        previewBox.classList.remove('error');
        placeholder.style.display = 'none';
        statusEl.textContent = '✅ Gambar berhasil dimuat';
        statusEl.className   = 'url-status ok';
        clearBtn.style.display = 'inline';
    });

    previewImg.addEventListener('error', function () {
        if (!coverInput.value) return;
        this.classList.remove('visible');
        previewBox.classList.remove('has-image');
        previewBox.classList.add('error');
        placeholder.style.display = 'flex';
        statusEl.textContent = '❌ URL tidak valid atau gambar tidak dapat dimuat';
        statusEl.className   = 'url-status err';
        clearBtn.style.display = 'inline';
    });

    let debounceTimer;
    coverInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const val = this.value.trim();
        if (!val) { resetPreview(); return; }
        debounceTimer = setTimeout(() => setPreview(val), 400);
    });

    coverInput.addEventListener('paste', function () {
        setTimeout(() => {
            const val = this.value.trim();
            if (val) setPreview(val);
        }, 50);
    });

    clearBtn.addEventListener('click', function () {
        coverInput.value = '';
        resetPreview();
    });

    // Auto-preview existing cover on page load
    const existingUrl = coverInput.value.trim();
    if (existingUrl) {
        setPreview(existingUrl);
    }
</script>
</body>
</html>
