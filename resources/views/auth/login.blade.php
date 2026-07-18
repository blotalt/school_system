<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Cambodia High School</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Figtree', -apple-system, Segoe UI, Roboto, sans-serif;
            background: #0a2f5c;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            width: 100%;
            max-width: 400px;
            border-radius: 14px;
            padding: 40px 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        }
        .logo {
            width: 44px; height: 44px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1fa2c8 0%, #2f6d4a 100%);
            display: block;
        }
        .title {
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            color: #1a2530;
            margin-bottom: 4px;
        }
        .subtitle {
            text-align: center;
            font-size: 13px;
            color: #8a94a3;
            margin-bottom: 28px;
        }
        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: 12px;
            color: #6a7383;
            margin-bottom: 6px;
        }
        .field input {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #dfe3e8;
            border-radius: 8px;
            font-size: 14px;
            color: #1a2530;
            transition: border-color .15s;
        }
        .field input:focus {
            outline: none;
            border-color: #1fa2c8;
            box-shadow: 0 0 0 3px rgba(31,162,200,0.12);
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #1fa2c8;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background .15s;
            margin-top: 4px;
        }
        .btn:hover { background: #1990b3; }
        .forgot {
            display: block;
            margin-top: 16px;
            font-size: 13px;
            color: #1fa2c8;
            text-decoration: none;
        }
        .forgot:hover { text-decoration: underline; }
        .error {
            color: #c0392b;
            font-size: 12px;
            margin-top: 5px;
        }
        .flash {
            background: #e6f7ec;
            border: 1px solid #b7e4c7;
            color: #2f6d4a;
            font-size: 13px;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>
    <div class="card">
        <span class="logo"></span>
        <div class="title">Welcome</div>
        <div class="subtitle">Sign in to your account</div>

        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username" placeholder="admin@school.test">
                @error('email') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password" placeholder="••••••••">
                @error('password') <div class="error">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn">Sign in</button>

            @if (Route::has('password.request'))
                <a class="forgot" href="{{ route('password.request') }}">Forgot password?</a>
            @endif
        </form>
    </div>
</body>
</html>