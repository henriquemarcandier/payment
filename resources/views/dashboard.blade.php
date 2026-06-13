<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Multi-Currency Payment</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar h2 {
            color: #fff;
            font-size: 18px;
            font-weight: 700;
        }

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
            color: rgba(255,255,255,0.7);
            font-size: 14px;
        }

        .navbar .user-info strong {
            color: #fff;
        }

        .navbar a {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 8px;
            font-size: 13px;
            transition: all 0.2s;
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 16px;
            padding: 32px;
            color: #fff;
            margin-bottom: 32px;
        }

        .welcome-card h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome-card p {
            opacity: 0.85;
            font-size: 15px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .stat-card .label {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
        }

        .info-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .info-card h3 {
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 16px;
        }

        .info-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-card td {
            padding: 10px 0;
            font-size: 14px;
            color: #4b5563;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-card td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .info-card tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge.employee {
            background: #dbeafe;
            color: #2563eb;
        }

        .badge.finance {
            background: #fef3c7;
            color: #d97706;
        }

        .converter-card {
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .converter-card h3 {
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 20px;
        }

        .converter-grid {
            display: flex;
            gap: 16px;
            align-items: end;
            flex-wrap: wrap;
        }

        .converter-field {
            flex: 1;
            min-width: 160px;
        }

        .converter-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .converter-field select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            background: #f9fafb;
            color: #1f2937;
            appearance: none;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .converter-field select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }

        .converter-btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            min-width: 100px;
        }

        .converter-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102,126,234,0.4);
        }

        .converter-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .converter-result {
            margin-top: 24px;
            padding: 20px;
            background: linear-gradient(135deg, #f0f4ff, #f5f0ff);
            border-radius: 12px;
            display: none;
        }

        .converter-result.show {
            display: block;
        }

        .converter-result .rate {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .converter-result .rate-sub {
            font-size: 14px;
            color: #6b7280;
            margin-top: 4px;
        }

        .converter-result .updated {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 8px;
        }

        .converter-error {
            margin-top: 16px;
            padding: 12px 16px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            color: #dc2626;
            font-size: 13px;
            display: none;
        }

        .converter-error.show {
            display: block;
        }

        .swap-btn {
            background: none;
            border: 1px solid #d1d5db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            color: #6b7280;
            transition: all 0.2s;
            flex-shrink: 0;
            margin-bottom: 2px;
        }

        .swap-btn:hover {
            border-color: #667eea;
            color: #667eea;
            background: #f0f4ff;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>&#x1F4B1; Multi-Currency Payment</h2>
        <div class="user-info">
            <span><strong>{{ Auth::user()->name }}</strong> 
                <span class="badge {{ Auth::user()->role }}">{{ Auth::user()->role }}</span>
            </span>
            <span>{{ Auth::user()->country }} ({{ Auth::user()->currency }})</span>
            <a href="logout">Sign Out</a>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p>You are logged in as <strong>{{ Auth::user()->role }}</strong> &mdash; {{ Auth::user()->country }}</p>
        </div>

        <div class="converter-card">
            <h3>&#x1F4B1; Currency Converter</h3>
            <form id="convertForm">
                @csrf
                <div class="converter-grid">
                    <div class="converter-field">
                        <label for="from">From</label>
                        <select name="from" id="from">
                            @foreach ($currencies as $c)
                                <option value="{{ $c }}" {{ $c === Auth::user()->currency ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" class="swap-btn" id="swapBtn" title="Swap currencies">&#x21C4;</button>

                    <div class="converter-field">
                        <label for="to">To</label>
                        <select name="to" id="to">
                            @foreach ($currencies as $c)
                                <option value="{{ $c }}" {{ $c === 'EUR' ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="converter-btn" id="convertBtn">Convert</button>
                </div>
            </form>

            <div class="converter-result" id="result">
                <div class="rate" id="rateDisplay">1 <span id="fromLabel"></span> = <span id="rateValue"></span> <span id="toLabel"></span></div>
                <div class="rate-sub" id="inverseDisplay">1 <span id="toLabel2"></span> = <span id="inverseValue"></span> <span id="fromLabel2"></span></div>
                <div class="updated" id="updatedDisplay"></div>
            </div>

            <div class="converter-error" id="error"></div>
        </div>

        <div style="text-align:center;margin-top:32px;padding:16px;color:#9ca3af;font-size:13px;border-top:1px solid #e5e7eb;">
            &copy; {{ date('Y') }} - Powered by Henrique Marcandier Marques Gonçalves
        </div>
    </div>

    <script>
        document.getElementById('swapBtn').addEventListener('click', function () {
            const from = document.getElementById('from');
            const to = document.getElementById('to');
            const tmp = from.value;
            from.value = to.value;
            to.value = tmp;
            document.getElementById('result').classList.remove('show');
            document.getElementById('error').classList.remove('show');
        });

        document.getElementById('convertForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = document.getElementById('convertBtn');
            btn.disabled = true;
            btn.textContent = 'Converting...';

            document.getElementById('result').classList.remove('show');
            document.getElementById('error').classList.remove('show');

            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;

            fetch('convert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({ from, to }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('fromLabel').textContent = data.from;
                    document.getElementById('toLabel').textContent = data.to;
                    document.getElementById('rateValue').textContent = data.rate;
                    document.getElementById('toLabel2').textContent = data.to;
                    document.getElementById('fromLabel2').textContent = data.from;
                    document.getElementById('inverseValue').textContent = data.rate > 0 ? (1 / data.rate).toFixed(6) : '0';
                    document.getElementById('updatedDisplay').textContent = 'Updated just now';
                    document.getElementById('result').classList.add('show');
                } else {
                    document.getElementById('error').textContent = data.message || 'Conversion failed.';
                    document.getElementById('error').classList.add('show');
                }
            })
            .catch(err => {
                document.getElementById('error').textContent = 'Network error. Please try again.';
                document.getElementById('error').classList.add('show');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Convert';
            });
        });
    </script>
</body>
</html>
