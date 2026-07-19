<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambodia High School - Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ad-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body{ background:#f4f6fb; display:flex; align-items:center; justify-content:center; min-height:100vh; }
        .login-card{ background:#fff; border-radius:16px; border:1px solid #e5e9f2; padding:40px; width:380px; box-shadow:0 8px 24px rgba(0,0,0,.06); }
        .login-card h1{ font-size:22px; color:#1e293b; margin-bottom:6px; }
        .login-card p{ color:#6b7280; font-size:14px; margin-bottom:24px; }
        .login-remember{ display:flex; align-items:center; gap:8px; margin:16px 0; font-size:14px; color:#374151; }
        .login-submit{ width:100%; margin-top:8px; justify-content:center; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Cambodia High School</h1>
        <p>Sign in to your account.</p>

        @if (session('status'))
            <div class="alert alert-success" style="margin-bottom:16px;padding:12px 16px;background:#e6f9f0;border:1px solid #10b981;border-radius:10px;color:#0a7a4d;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required autocomplete="current-password">
                @error('password') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <label class="login-remember">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <button type="submit" class="save-btn login-submit">Log In</button>
        </form>
    </div>
</body>
</html>
