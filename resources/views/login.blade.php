<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-Currency Payment</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .login-header .icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .login-header h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-group input:focus {
            border-color: #667eea;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .form-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px;
            cursor: pointer;
        }

        .form-options input[type="checkbox"] {
            accent-color: #667eea;
            width: 16px;
            height: 16px;
        }

        .form-options a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 13px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .form-options a:hover {
            color: #667eea;
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .erro {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: center;
        }

        .login-footer {
            text-align: center;
            margin-top: 24px;
        }

        .login-footer p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
        }

        .login-footer a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .login-footer a:hover {
            color: #667eea;
        }

        .users-list {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .users-list summary {
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
            cursor: pointer;
        }

        .users-list table {
            width: 100%;
            margin-top: 12px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.5);
            border-collapse: collapse;
        }

        .users-list td {
            padding: 4px 0;
        }

        .users-list td:last-child {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="icon">&#x1F4B1;</div>
            <h1>Multi-Currency Payment</h1>
            <p>Sign in to manage your payments</p>
        </div>

        @if ($errors->any())
            <div class="erro">{{ $errors->first('email') }}</div>
        @endif

        <form method="POST" action="login">
            @csrf
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="your@email.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="••••••••" required>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit">Sign In</button>
        </form>

        <details class="users-list">
            <summary>Test users</summary>
            <table>
                <tr><td>ana@empresa.com</td><td>employee</td><td>EUR</td></tr>
                <tr><td>john@empresa.com</td><td>employee</td><td>GBP</td></tr>
                <tr><td>maria@empresa.com</td><td>employee</td><td>EUR</td></tr>
                <tr><td>takashi@empresa.com</td><td>employee</td><td>JPY</td></tr>
                <tr><td>sarah@empresa.com</td><td>employee</td><td>USD</td></tr>
                <tr><td>carlos@empresa.com</td><td>employee</td><td>BRL</td></tr>
                <tr><td>finance@empresa.com</td><td>finance</td><td>EUR</td></tr>
                <tr><td colspan="2" style="text-align:center;padding-top:8px;color:rgba(255,255,255,0.3);">Password: <strong>password</strong></td></tr>
            </table>
        </details>

        <div class="login-footer">
            <p>&copy; {{ date('Y') }} - Desenvolvido por Henrique Marcandier Marques Gonçalves</p>
        </div>
    </div>
</body>
</html>
