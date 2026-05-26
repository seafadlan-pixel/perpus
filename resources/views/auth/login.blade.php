<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - International Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
        }
        .login-left {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-right {
            padding: 50px;
        }
        .btn-primary {
            background-color: #ff6b6b;
            border: none;
            border-radius: 30px;
            padding: 12px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #ff5252;
        }
    </style>
</head>
<body>

    <div class="login-card row g-0">
        <div class="col-md-5 login-left d-none d-md-flex">
            <h2>🌎 International Library</h2>
            <p class="mt-3 opacity-75">Welcome back! Please login to access your account.</p>
            <div class="mt-auto">
                <a href="{{ route('public.index') }}" class="text-white text-decoration-none">&larr; Back to Home</a>
            </div>
        </div>
        <div class="col-md-7 login-right">
            <h3 class="fw-bold mb-4">Login</h3>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Email Address</label>
                    <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required placeholder="••••••••">
                </div>
                
                <div class="d-grid mt-5">
                    <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
                </div>
            </form>
            
            <div class="mt-4 text-center text-muted">
                <p>Admin: admin@admin.com / password<br>Visitor: visitor@visitor.com / password</p>
            </div>
        </div>
    </div>

</body>
</html>
