<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Installer &middot; <?php echo e(config('app.name', 'Blossom')); ?></title>
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
            max-width: 640px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(28, 25, 23, 0.08);
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
        .subtitle { color: var(--muted); font-size: 14px; margin-bottom: 28px; }
        h1 { font-size: 22px; margin-bottom: 8px; color: var(--ink); }
        h2 { font-size: 16px; margin-bottom: 12px; color: var(--ink); }
        p { font-size: 14px; color: var(--muted); margin-bottom: 16px; }
        .checks { list-style: none; margin: 12px 0 24px; }
        .checks li {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 6px;
        }
        .checks li.ok { background: #f0fdf4; color: #166534; }
        .checks li.fail { background: #fef2f2; color: #b91c1c; }
        .checks li.warn { background: #fffbeb; color: #92400e; }
        .checks li::before { content: "✓"; font-weight: 700; }
        .checks li.fail::before { content: "✕"; }
        .checks li.warn::before { content: "•"; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; }
        label small { font-weight: 400; color: var(--muted); }
        input[type="text"], input[type="email"], input[type="password"], input[type="url"], input[type="number"], select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--silver);
            border-radius: 8px;
            font-size: 14px;
            background: var(--white);
            color: var(--ink);
        }
        input:focus, select:focus { outline: 2px solid var(--orange); border-color: transparent; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
        @media (max-width: 520px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }
        .section { border-top: 1px solid var(--silver); margin-top: 24px; padding-top: 24px; }
        .section:first-of-type { border-top: 0; margin-top: 0; padding-top: 0; }
        .btn {
            display: inline-block;
            width: 100%;
            padding: 12px 16px;
            border: 0;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            background: var(--onion);
            color: var(--white);
            transition: opacity 0.2s;
        }
        .btn:hover { opacity: 0.9; }
        .btn[disabled] { opacity: 0.5; cursor: not-allowed; }
        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-size: 13px;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 16px;
        }
        .error-box ul { margin-left: 18px; }
        .field-error { color: #b91c1c; font-size: 12px; margin-top: 4px; }
        .db-hint { font-size: 12px; color: var(--muted); margin-top: 6px; }
        .success-icon {
            width: 64px; height: 64px; border-radius: 50%;
            background: #f0fdf4; color: #166534;
            display: flex; align-items: center; justify-content: center;
            font-size: 30px; margin: 0 auto 20px;
        }
        .text-center { text-align: center; }
        .mt { margin-top: 20px; }
        .lock-note { font-size: 12px; color: var(--muted); margin-top: 24px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <div class="text-center">
            <div class="logo">BLOSS<span>OM</span></div>
            <div class="subtitle">Installation Wizard</div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="error-box">
                <strong>There was a problem:</strong>
                <ul>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php
            $allPass = ! collect($requirements)->contains(function ($r) {
                return $r['blocking'] && ! $r['ok'];
            }) && ! collect($writable)->contains(false);
        ?>

        <h1>Welcome</h1>
        <p>Thanks for choosing <?php echo e(config('app.name', 'Blossom')); ?>. Before we get started, let's make sure your server is ready.</p>

        <h2>Server Requirements</h2>
        <ul class="checks">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $requirements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $check): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="<?php echo e($check['ok'] ? 'ok' : ($check['blocking'] ? 'fail' : 'warn')); ?>"><?php echo e($label); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>

        <h2>Folder Permissions</h2>
        <ul class="checks">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $writable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $ok): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="<?php echo e($ok ? 'ok' : 'warn'); ?>"><?php echo e($label); ?> <small>(must be writable)</small></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(! $allPass): ?>
            <p>Please fix the issues above, then refresh this page to continue.</p>
        <?php else: ?>
            <div class="section">
                <h1>Database &amp; Site</h1>
                <p>This will create your database, run the migrations, seed the demo content, and create your admin account. The app is fully domain-agnostic — it will work on whatever domain you host it on.</p>

                <form method="POST" action="<?php echo e(route('install.run')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="app_name">Site Name</label>
                        <input type="text" id="app_name" name="app_name" value="<?php echo e(old('app_name', 'BLOSSOM')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="app_url">Site URL <small>(your domain)</small></label>
                        <input type="url" id="app_url" name="app_url" value="<?php echo e(old('app_url', url('/'))); ?>" placeholder="https://example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="db_connection">Database Driver</label>
                        <select id="db_connection" name="db_connection" onchange="toggleDbFields()">
                            <option value="sqlite" <?php echo e(old('db_connection', 'sqlite') === 'sqlite' ? 'selected' : ''); ?>>SQLite (recommended — zero config)</option>
                            <option value="mysql" <?php echo e(old('db_connection') === 'mysql' ? 'selected' : ''); ?>>MySQL</option>
                            <option value="pgsql" <?php echo e(old('db_connection') === 'pgsql' ? 'selected' : ''); ?>>PostgreSQL</option>
                        </select>
                        <p class="db-hint">SQLite needs no server and is perfect for getting started. You can switch later.</p>
                    </div>

                    <div id="sqlite-fields">
                        <div class="form-group">
                            <label for="db_database_sqlite">Database File</label>
                            <input type="text" id="db_database_sqlite" name="db_database" value="<?php echo e(old('db_database', 'database/database.sqlite')); ?>">
                            <p class="db-hint">Path is relative to the project root. Ensure the file exists (you can create an empty one).</p>
                        </div>
                    </div>

                    <div id="server-db-fields" style="display:none">
                        <div class="grid-3">
                            <div class="form-group">
                                <label for="db_host">Host</label>
                                <input type="text" id="db_host" name="db_host" value="<?php echo e(old('db_host', '127.0.0.1')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="db_port">Port</label>
                                <input type="number" id="db_port" name="db_port" value="<?php echo e(old('db_port', '3306')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="db_database_server">Database</label>
                                <input type="text" id="db_database_server" name="db_database" value="<?php echo e(old('db_database')); ?>">
                            </div>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label for="db_username">Username</label>
                                <input type="text" id="db_username" name="db_username" value="<?php echo e(old('db_username')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="db_password">Password</label>
                                <input type="password" id="db_password" name="db_password" value="<?php echo e(old('db_password')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <h2>Admin Account</h2>
                        <div class="form-group">
                            <label for="admin_name">Full Name</label>
                            <input type="text" id="admin_name" name="admin_name" value="<?php echo e(old('admin_name', 'Admin')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Admin Email</label>
                            <input type="email" id="admin_email" name="admin_email" value="<?php echo e(old('admin_email')); ?>" placeholder="you@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_password">Admin Password <small>(min 8 characters)</small></label>
                            <input type="password" id="admin_password" name="admin_password" required>
                        </div>
                    </div>

                    <div class="section">
                        <h2>Mail (optional)</h2>
                        <p>Skip for now and configure mail from the admin panel later.</p>
                        <div class="grid-2">
                            <div class="form-group">
                                <label for="mail_host">SMTP Host</label>
                                <input type="text" id="mail_host" name="mail_host" value="<?php echo e(old('mail_host')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="mail_port">SMTP Port</label>
                                <input type="number" id="mail_port" name="mail_port" value="<?php echo e(old('mail_port')); ?>">
                            </div>
                        </div>
                        <div class="grid-2">
                            <div class="form-group">
                                <label for="mail_username">SMTP Username</label>
                                <input type="text" id="mail_username" name="mail_username" value="<?php echo e(old('mail_username')); ?>">
                            </div>
                            <div class="form-group">
                                <label for="mail_password">SMTP Password</label>
                                <input type="password" id="mail_password" name="mail_password" value="<?php echo e(old('mail_password')); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mail_from_address">From Address</label>
                            <input type="email" id="mail_from_address" name="mail_from_address" value="<?php echo e(old('mail_from_address')); ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn mt" onclick="this.disabled=true; this.textContent='Installing… please wait'; this.form.submit();">Install Now</button>
                </form>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <script>
        function toggleDbFields() {
            var v = document.getElementById('db_connection').value;
            document.getElementById('sqlite-fields').style.display = v === 'sqlite' ? '' : 'none';
            document.getElementById('server-db-fields').style.display = v === 'sqlite' ? 'none' : '';
            document.getElementById('db_port').value = v === 'pgsql' ? '5432' : '3306';
        }
    </script>
</body>
</html><?php /**PATH C:\WebWorka\codeworkflow\blossom\resources\views/install/welcome.blade.php ENDPATH**/ ?>