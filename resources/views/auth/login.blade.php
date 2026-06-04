<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lentera Pustaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            border: 1px solid #e2e8f0;
        }
        .brand-text {
            color: #0f172a;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 8px;
        }
        .subtitle {
            color: #64748b;
            text-align: center;
            font-size: 0.95rem;
            margin-bottom: 32px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background-color: #0f172a;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background-color: #334155;
        }
        .form-label {
            font-weight: 500;
            color: #334155;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand-text">📚 Lentera Pustaka</div>
        <div class="subtitle">Silakan login untuk melanjutkan</div>
        
        @if (session('success'))
            <div class="alert alert-success py-2 px-3 text-sm rounded-3 mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 text-sm rounded-3 mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
            </div>
            
            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sign In</button>
            </div>
        </form>

        <div class="text-center mt-3" style="font-size: 0.9rem; color: #64748b;">
            Don't have an account? <a href="{{ route('register') }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Sign Up</a>
        </div>
        
        <div class="mt-4 text-center" style="font-size: 0.85rem; color: #94a3b8; border-top: 1px solid #f1f5f9; pt-3;">
            Admin: admin@admin.com / password<br>Visitor: visitor@visitor.com / password
        </div>
    </div>

</body>
</html>
