<?php
/** @var \App\View\AppView $this */
/** @var array $data */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
    <style>
        body{font-family: Arial, Helvetica, sans-serif; color:#f5f5f7; margin:0; padding:0; background:#121212;}
        .container{max-width:740px; margin:24px auto; background:#1e1e1e; border-radius:10px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,.35);}
        .header{background:#000; color:#f5f5f7; padding:24px 28px; border-bottom:3px solid #f0b95b}
        .brand{font-size:12px; letter-spacing:2px; color:#cfa15d; text-transform:uppercase; margin:0 0 6px 0}
        .header h1{margin:0; font-size:22px; line-height:1.3}
        .content{padding:26px 28px}
        .muted{color:#86868b}
        .grid{background:#171717; border:1px solid rgba(255,255,255,.08); border-radius:8px; padding:0; overflow:hidden}
        .row{display:flex; border-bottom:1px solid rgba(255,255,255,.08)}
        .row:last-child{border-bottom:none}
        .cell{flex:1; padding:12px 14px; font-size:14px}
        .cell.label{color:#c9c9cc; width:30%; max-width:220px; background:#151515}
        .cell.val{color:#f5f5f7}
        .message{padding:12px 14px;}
        .footer{padding:18px 28px; font-size:12px; color:#86868b; background:#151515}
        a{color:#cfa15d; text-decoration:none}
        .small{font-size:12px; color:#86868b}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">Brewhub</div>
        <h1>New contact form submission</h1>
    </div>
    <div class="content">
        <div class="grid">
            <div class="row">
                <div class="cell label">Name</div>
                <div class="cell val"><?= h(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')) ?></div>
            </div>
            <div class="row">
                <div class="cell label">Email</div>
                <div class="cell val"><?= h($data['email'] ?? '') ?></div>
            </div>
            <div class="row">
                <div class="cell label">Submitted</div>
                <div class="cell val"><?= date('M j, Y g:i A') ?></div>
            </div>
        </div>
        <div class="message">
            <div class="muted" style="margin:10px 0 6px 0;">Message</div>
            <div><?= nl2br(h($data['message'] ?? '')) ?></div>
        </div>
        <p class="small">Replying to this email will reply to the customer.</p>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Brewhub. All rights reserved.
    </div>
</div>
</body>
</html>
