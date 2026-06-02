<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - International Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }
        .register-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            width: 100%;
            max-width: 440px;
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
        .login-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="brand-text">📚 International Library</div>
        <div class="subtitle">Create a new account to explore our library</div>
        
        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 text-sm rounded-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="John Doe">
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="name@example.com">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
            </div>
            
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
        
        <div class="text-center mt-3" style="font-size: 0.9rem; color: #64748b;">
            Already have an account? <a href="{{ route('login') }}" class="login-link">Sign In</a>
        </div>
    </div>

</body>
</html>
