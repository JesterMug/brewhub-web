<?php
/** @var \App\View\AppView $this */
/** @var array $data */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanks for contacting Brewhub</title>
    <style>
        body{font-family: Arial, Helvetica, sans-serif; color:#f5f5f7; margin:0; padding:0; background:#121212;}
        .container{max-width:680px; margin:24px auto; background:#1e1e1e; border-radius:10px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,.35);}
        .header{background:#000; color:#f5f5f7; padding:24px 28px; border-bottom:3px solid #f0b95b}
        .brand{font-size:12px; letter-spacing:2px; color:#cfa15d; text-transform:uppercase; margin:0 0 6px 0}
        .header h1{margin:0; font-size:22px; line-height:1.3}
        .content{padding:26px 28px}
        .muted{color:#86868b}
        .card{background:#171717; border:1px solid rgba(255,255,255,.08); border-radius:8px; padding:14px 16px;}
        .footer{padding:18px 28px; font-size:12px; color:#86868b; background:#151515}
        a{color:#cfa15d; text-decoration:none}
        .label{color:#c9c9cc; font-size:12px; text-transform:uppercase; letter-spacing:1px}
        .val{color:#f5f5f7; font-size:14px}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">Brewhub</div>
        <h1>Thanks, we've received your message</h1>
    </div>
    <div class="content">
        <p class="muted">Hi <?= h(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?>,</p>
        <p>We appreciate you getting in touch. Our team will review your message and get back to you soon.</p>

        <div class="card" style="margin-top:12px;">
            <div class="label">Your message</div>
            <div class="val"><?= nl2br(h($data['message'] ?? '')) ?></div>
        </div>

        <p class="muted" style="margin-top:14px;">Sent on <?= date('M j, Y g:i A') ?></p>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Brewhub. All rights reserved.
    </div>
</div>
</body>
</html>
