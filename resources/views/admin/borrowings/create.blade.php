<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pinjamkan Buku ke Member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #334155; }
        .sidebar { background: #0f172a; min-height: 100vh; color: white; padding-top: 24px; box-shadow: 1px 0 0 #e2e8f0; display: flex; flex-direction: column; width: 250px; min-width: 250px; flex-shrink: 0; }
        .sidebar h4 { font-size: 1.1rem; font-weight: 700; color: #ffffff; letter-spacing: -0.02em; opacity: 0.95; }
        .sidebar a { color: #94a3b8; text-decoration: none; padding: 12px 24px; display: block; font-size: 0.875rem; font-weight: 500; transition: all 0.15s; white-space: nowrap; }
        .sidebar a:hover, .sidebar a.active { background: #1e293b; color: white; }
        .main-content { padding: 40px; }

        .form-card {
            background: white;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .form-card-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%);
            color: white;
            padding: 28px 32px;
        }

        .form-card-header h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .form-card-header p {
            margin: 6px 0 0;
            font-size: 0.85rem;
            opacity: 0.75;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.3);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            margin-bottom: 10px;
        }

        .form-body { padding: 32px; }

        .section-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 10px 14px;
            color: #334155;
            transition: all 0.15s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .member-info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
            margin-top: 10px;
            display: none;
        }

        .member-info-box .info-name { font-size: 0.9rem; font-weight: 600; color: #0f172a; }
        .member-info-box .info-meta { font-size: 0.78rem; color: #64748b; margin-top: 2px; }

        /* Book Search */
        .book-search-wrapper {
            position: relative;
        }

        .book-search-input {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            padding: 10px 14px 10px 40px;
            color: #334155;
            width: 100%;
            transition: all 0.15s;
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zm-5.242 1.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z'/%3E%3C/svg%3E") no-repeat 12px center;
        }

        .book-search-input:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
            outline: none;
        }

        .book-search-results {
            position: absolute;
            top: calc(100% + 6px);
            left: 0; right: 0;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            max-height: 320px;
            overflow-y: auto;
            z-index: 999;
            display: none;
        }

        .book-result-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.12s;
        }

        .book-result-item:last-child { border-bottom: none; }

        .book-result-item:hover, .book-result-item.highlighted {
            background: #eff6ff;
        }

        .book-result-icon {
            font-size: 1.6rem;
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .book-result-title { font-size: 0.875rem; font-weight: 600; color: #0f172a; }
        .book-result-author { font-size: 0.75rem; color: #64748b; margin-top: 1px; }
        .book-result-stock {
            margin-left: auto;
            font-size: 0.72rem;
            font-weight: 600;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            padding: 3px 8px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .book-no-results {
            padding: 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .book-selected-card {
            background: #eff6ff;
            border: 1.5px solid #93c5fd;
            border-radius: 10px;
            padding: 14px 16px;
            margin-top: 10px;
            display: none;
            align-items: center;
            gap: 14px;
        }

        .book-selected-card .sel-icon {
            font-size: 1.6rem;
            width: 40px;
            height: 40px;
            background: #dbeafe;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .book-selected-card .sel-title { font-size: 0.9rem; font-weight: 700; color: #1e40af; }
        .book-selected-card .sel-meta { font-size: 0.75rem; color: #3b82f6; margin-top: 2px; }

        .book-selected-card .btn-clear-book {
            margin-left: auto;
            background: none;
            border: 1px solid #bfdbfe;
            border-radius: 6px;
            color: #3b82f6;
            font-size: 0.72rem;
            padding: 4px 10px;
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .book-selected-card .btn-clear-book:hover {
            background: #dbeafe;
        }

        .approval-notice {
            background: linear-gradient(135deg, #ecfdf5, #f0fdf4);
            border: 1px solid #a7f3d0;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .approval-notice .icon { font-size: 1.4rem; flex-shrink: 0; }
        .approval-notice .text-title { font-size: 0.85rem; font-weight: 600; color: #047857; }
        .approval-notice .text-desc { font-size: 0.78rem; color: #065f46; margin-top: 2px; }

        .btn-submit-admin {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-submit-admin:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.3);
        }

        .btn-cancel {
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s;
        }

        .btn-cancel:hover {
            background: #f8fafc;
            color: #334155;
        }

        .duration-preview {
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 6px;
        }

        .duration-preview strong { color: #1d4ed8; }

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
            .form-body {
                padding: 20px !important;
            }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px; position: sticky; top: 0; height: 100vh;">
        <h4 class="text-center mb-4">Library Admin</h4>
        <a href="{{ route('books.index') }}">📚 Book Management</a>
        <a href="{{ route('admin.borrowings.index') }}" class="active">📋 Borrowing Management</a>
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

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="{{ route('admin.borrowings.index') }}" style="color: #64748b; text-decoration: none;">Borrowing Management</a></li>
                <li class="breadcrumb-item active" style="color: #0f172a; font-weight: 600;">Pinjamkan Buku</li>
            </ol>
        </nav>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Notice: Berbeda dari Visitor -->
        <div class="approval-notice">
            <div class="icon">⚡</div>
            <div>
                <div class="text-title">Mode Peminjaman Admin — Langsung Disetujui</div>
                <div class="text-desc">
                    Berbeda dari peminjaman visitor yang perlu menunggu approval, peminjaman melalui admin akan <strong>langsung berstatus "Dipinjam"</strong> dan stok buku dikurangi secara otomatis.
                </div>
            </div>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <div class="admin-badge">⚙️ ADMIN ONLY</div>
                <h3>Pinjamkan Buku ke Member</h3>
                <p>Isi formulir di bawah untuk meminjamkan buku langsung kepada anggota perpustakaan</p>
            </div>

            <div class="form-body">
                <form action="{{ route('admin.borrowings.store') }}" method="POST" id="adminBorrowForm">
                    @csrf

                    <!-- Section: Pilih Member -->
                    <div class="section-label">👤 Data Member</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Pilih Member <span class="text-danger">*</span></label>
                            <select name="user_id" id="memberSelect" class="form-select" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                        data-name="{{ $member->name }}"
                                        data-email="{{ $member->email }}"
                                        data-class="{{ $member->class ?? '' }}"
                                        {{ old('user_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} @if($member->class) ({{ $member->class }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="member-info-box" id="memberInfoBox">
                                <div class="info-name" id="memberName"></div>
                                <div class="info-meta" id="memberMeta"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nama Peminjam <span class="text-danger">*</span></label>
                            <input type="text" name="borrower_name" id="borrowerName" class="form-control"
                                   placeholder="Nama lengkap peminjam"
                                   value="{{ old('borrower_name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="borrower_phone" class="form-control"
                                   placeholder="Contoh: 0812-xxxx-xxxx"
                                   value="{{ old('borrower_phone') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="borrower_address" class="form-control"
                                   placeholder="Alamat peminjam (opsional)"
                                   value="{{ old('borrower_address') }}">
                        </div>
                    </div>

                    <!-- Section: Pilih Buku -->
                    <div class="section-label">📚 Pilih Buku</div>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <label class="form-label">Buku yang Dipinjam <span class="text-danger">*</span></label>

                            {{-- Search filter input --}}
                            <div style="position: relative; margin-bottom: 8px;">
                                <input type="text" id="bookFilterInput" class="form-control"
                                    placeholder="🔍 Cari judul atau nama penulis..."
                                    autocomplete="off"
                                    style="padding-left: 36px; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='15' height='15' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.099zm-5.242 1.656a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: 12px center;">
                            </div>

                            {{-- Select langsung ber-name book_id --}}
                            <select name="book_id" id="bookSelect" class="form-select" required size="6"
                                style="height: auto; border-radius: 8px;">
                                <option value="">-- Pilih buku dari daftar --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}"
                                        data-title="{{ $book->title }}"
                                        data-author="{{ $book->author }}"
                                        data-stock="{{ $book->stock }}"
                                        {{ (old('book_id', $preselectedBookId ?? '') == $book->id) ? 'selected' : '' }}>
                                        {{ $book->title }} — {{ $book->author }} (Stok: {{ $book->stock }})
                                    </option>
                                @endforeach
                            </select>

                            {{-- Info buku yang dipilih --}}
                            <div class="book-info-box" id="bookInfoBox" style="display:none; margin-top:10px;">
                                <div id="bookInfoTitle" style="font-size:0.9rem; font-weight:600; color:#1e40af;"></div>
                                <div id="bookInfoMeta" style="font-size:0.78rem; color:#3b82f6; margin-top:2px;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Tanggal Peminjaman -->
                    <div class="section-label">📅 Jadwal Peminjaman</div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pinjam <span class="text-danger">*</span></label>
                            <input type="date" name="borrow_date" id="borrowDate" class="form-control"
                                   value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Durasi Peminjaman <span class="text-danger">*</span></label>
                            <select name="duration" id="durationSelect" class="form-select" required>
                                <option value="3" {{ old('duration') == 3 ? 'selected' : '' }}>3 Hari</option>
                                <option value="7" {{ old('duration', 7) == 7 ? 'selected' : '' }}>7 Hari (1 Minggu)</option>
                                <option value="14" {{ old('duration') == 14 ? 'selected' : '' }}>14 Hari (2 Minggu)</option>
                                <option value="21" {{ old('duration') == 21 ? 'selected' : '' }}>21 Hari (3 Minggu)</option>
                                <option value="30" {{ old('duration') == 30 ? 'selected' : '' }}>30 Hari (1 Bulan)</option>
                            </select>
                            <div class="duration-preview" id="durationPreview">
                                Jatuh tempo: <strong id="dueDatePreview">–</strong>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3"
                                      placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex align-items-center gap-3 pt-2">
                        <button type="submit" class="btn-submit-admin" id="submitBtn">
                            ⚡ Pinjamkan Sekarang
                        </button>
                        <a href="{{ route('admin.borrowings.index') }}" class="btn-cancel">← Batal</a>
                        <span style="font-size: 0.75rem; color: #94a3b8; margin-left: auto;">
                            Status akan langsung: <span style="color: #1d4ed8; font-weight: 600;">✅ Dipinjam</span>
                        </span>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-fill borrower name from member selection
    const memberSelect = document.getElementById('memberSelect');
    const memberInfoBox = document.getElementById('memberInfoBox');
    const memberNameEl = document.getElementById('memberName');
    const memberMetaEl = document.getElementById('memberMeta');
    const borrowerNameInput = document.getElementById('borrowerName');

    memberSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (this.value) {
            memberNameEl.textContent = opt.dataset.name;
            let meta = opt.dataset.email;
            if (opt.dataset.class) meta += ' · Kelas ' + opt.dataset.class;
            memberMetaEl.textContent = meta;
            memberInfoBox.style.display = 'block';
            // Auto-fill borrower name
            if (!borrowerNameInput.value || borrowerNameInput.dataset.autofilled === 'true') {
                borrowerNameInput.value = opt.dataset.name;
                borrowerNameInput.dataset.autofilled = 'true';
            }
        } else {
            memberInfoBox.style.display = 'none';
        }
    });

    // Clear autofilled flag if user manually edits
    borrowerNameInput.addEventListener('input', function () {
        this.dataset.autofilled = 'false';
    });

    // ── Book Filter + Select ──────────────────────────────────────────────────
    const bookFilterInput = document.getElementById('bookFilterInput');
    const bookSelect      = document.getElementById('bookSelect');
    const bookInfoBox     = document.getElementById('bookInfoBox');
    const bookInfoTitle   = document.getElementById('bookInfoTitle');
    const bookInfoMeta    = document.getElementById('bookInfoMeta');

    // Simpan semua options asli
    const allOptions = Array.from(bookSelect.options);

    bookFilterInput.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        // Hapus semua options lalu tambah kembali yang cocok
        bookSelect.innerHTML = '';
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = q ? '-- Pilih dari hasil pencarian --' : '-- Pilih buku dari daftar --';
        bookSelect.appendChild(placeholder);

        allOptions.forEach(opt => {
            if (!opt.value) return; // skip placeholder asli
            const title  = (opt.dataset.title  || '').toLowerCase();
            const author = (opt.dataset.author || '').toLowerCase();
            if (!q || title.includes(q) || author.includes(q)) {
                bookSelect.appendChild(opt.cloneNode(true));
            }
        });

        // Auto-pilih jika hanya 1 hasil
        if (bookSelect.options.length === 2) {
            bookSelect.options[1].selected = true;
            bookSelect.dispatchEvent(new Event('change'));
        } else {
            bookInfoBox.style.display = 'none';
        }
    });

    bookSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (this.value && opt) {
            bookInfoTitle.textContent = opt.dataset.title || opt.textContent.trim();
            bookInfoMeta.textContent  = 'Penulis: ' + (opt.dataset.author || '-') + '  ·  Sisa stok: ' + (opt.dataset.stock || '-') + ' buku';
            bookInfoBox.style.display = 'block';
        } else {
            bookInfoBox.style.display = 'none';
        }
    });

    // Tampilkan info jika ada nilai terpilih (pre-selected / old input)
    if (bookSelect.value) bookSelect.dispatchEvent(new Event('change'));

    // Due date preview
    function updateDueDate() {
        const borrowDate = document.getElementById('borrowDate').value;
        const duration = parseInt(document.getElementById('durationSelect').value);
        if (borrowDate && duration) {
            const due = new Date(borrowDate);
            due.setDate(due.getDate() + duration);
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            document.getElementById('dueDatePreview').textContent = due.toLocaleDateString('id-ID', options);
        }
    }

    document.getElementById('borrowDate').addEventListener('change', updateDueDate);
    document.getElementById('durationSelect').addEventListener('change', updateDueDate);
    updateDueDate();

    // Trigger member change for old() value
    if (memberSelect.value) memberSelect.dispatchEvent(new Event('change'));
</script>
</body>
</html>
