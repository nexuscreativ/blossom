<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installation Complete &middot; {{ config('app.name', 'Blossom') }}</title>
    <style>
        :root {
            --ink: #1c1917;
            --onion: #14532d;
            --orange: #ea580c;
            --silver: #e7e5e4;
            --pearl: #fafaf9;
            --white: #ffffff;
            --muted: #78716c;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            background: var(--pearl);
            color: var(--ink);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }
        .card {
            background: var(--white);
            border: 1px solid var(--silver);
            border-radius: 16px;
            width: 100%;
            max-width: 560px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(28, 25, 23, 0.08);
            text-align: center;
        }
        .logo {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.02em;
            color: var(--onion);
            margin-bottom: 6px;
        }
        .logo span { color: var(--orange); }
        .success-icon {
            width: 72px; height: 72px; border-radius: 50%;
            background: #f0fdf4; color: #166534;
            display: flex; align-items: center; justify-content: center;
            font-size: 34px; margin: 28px auto 24px;
        }
        h1 { font-size: 24px; margin-bottom: 10px; }
        p { font-size: 14px; color: var(--muted); margin-bottom: 12px; }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            background: var(--onion);
            color: var(--white);
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.9; }
        .btn-secondary {
            background: transparent;
            color: var(--onion);
            border: 1px solid var(--silver);
            margin-left: 10px;
        }
        .notes {
            text-align: left;
            background: #f5f5f4;
            border-radius: 10px;
            padding: 16px 18px;
            margin-top: 24px;
            font-size: 13px;
            color: var(--ink);
        }
        .notes h3 { font-size: 14px; margin-bottom: 8px; }
        .notes ul { margin-left: 18px; }
        .notes li { margin-bottom: 4px; color: var(--muted); }
        .notes code {
            background: #e7e5e4;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">BLOSS<span>OM</span></div>
        <div class="success-icon">✓</div>
        <h1>Installation Complete</h1>
        <p>Your magazine is ready. The demo content, settings, and your admin account have all been created.</p>

        <div class="notes">
            <h3>Next steps</h3>
            <ul>
                <li>Configure payment, email, SMS, storage &amp; analytics in <strong>Admin &rarr; Services</strong>.</li>
                <li>Edit your site name, contact details &amp; social links in <strong>Admin &rarr; Settings</strong>.</li>
                <li>Enable the AI support chat (WhatsApp / Telegram / voice) in <strong>Admin &rarr; Chatbot</strong>.</li>
                <li>To re-run the installer on a new domain, delete <code>storage/app/installed</code> and update <code>.env</code>.</li>
            </ul>
        </div>

        <a class="btn" href="{{ route('home') }}">Visit Site</a>
        <a class="btn btn-secondary" href="/admin">Open Admin</a>
    </div>
</body>
</html>