<?php
/** @var \App\View\AppView $this */
/** @var array $order */
/** @var array $items */
/** @var float $subtotal */
/** @var float $total */
/** @var array|null $shipping */
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body{font-family: Arial, Helvetica, sans-serif; color:#f5f5f7; margin:0; padding:0; background:#121212;}
        .container{max-width:680px; margin:24px auto; background:#1e1e1e; border-radius:10px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,.35);}
        .header{background:#000; color:#f5f5f7; padding:24px 28px; border-bottom:3px solid #f0b95b}
        .brand{font-size:12px; letter-spacing:2px; color:#cfa15d; text-transform:uppercase; margin:0 0 6px 0}
        .header h1{margin:0; font-size:22px; line-height:1.3}
        .content{padding:26px 28px}
        .order-meta{margin:0 0 16px 0; color:#c9c9cc}
        .address{margin:0 0 12px 0; color:#86868b}
        .items{width:100%; border-collapse:collapse; margin-top:10px; background:#171717; border:1px solid rgba(255,255,255,.08); border-radius:8px; overflow:hidden}
        .items th, .items td{padding:12px 10px; border-bottom:1px solid rgba(255,255,255,.08); text-align:left; font-size:14px}
        .items thead th{background:#151515; font-weight:bold; color:#f5f5f7}
        .items tbody tr:last-child td{border-bottom:none}
        .muted{color:#86868b}
        .total-wrap{margin-top:16px; padding:12px 14px; background:#151515; border:1px solid #f0b95b; border-radius:6px}
        .total{margin:0; font-size:16px; font-weight:bold; text-align:right; color:#f5f5f7}
        .footer{padding:18px 28px; font-size:12px; color:#86868b; background:#151515}
        a{color:#cfa15d; text-decoration:none}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="brand">Brewhub</div>
        <h1>Thank you for your order!</h1>
    </div>
    <div class="content">
        <p class="order-meta">Order #<?= h($order['id'] ?? '') ?> placed on <?= h($order['order_date'] ?? '') ?></p>

        <?php if (!empty($shipping)): ?>
            <p class="address">Shipping to:<br>
                <?= h($shipping['name'] ?? '') ?><br>
                <?= h($shipping['line1'] ?? '') ?><?= !empty($shipping['line2']) ? ', ' . h($shipping['line2']) : '' ?><br>
                <?= h($shipping['city'] ?? '') ?>, <?= h($shipping['state'] ?? '') ?> <?= h($shipping['postal_code'] ?? '') ?><br>
                <?= h($shipping['country'] ?? '') ?>
            </p>
        <?php endif; ?>

        <table class="items" role="presentation">
            <thead>
            <tr>
                <th style="width:55%">Item</th>
                <th style="width:15%">Qty</th>
                <th style="width:15%">Price</th>
                <th style="width:15%">Line</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $it): ?>
                <tr>
                    <td>
                        <?= h($it['name']) ?>
                        <?php if (!empty($it['variant'])): ?>
                            <div class="muted">Variant: <?= h($it['variant']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($it['is_preorder'])): ?>
                            <div class="muted">Pre-Order</div>
                        <?php endif; ?>
                    </td>
                    <td><?= (int)$it['qty'] ?></td>
                    <td>$<?= number_format((float)$it['price'], 2) ?></td>
                    <td>$<?= number_format((float)$it['line_total'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total-wrap">
            <p class="total">Subtotal: $<?= number_format((float)$subtotal, 2) ?></p>
        </div>
        <p class="muted">You will receive another email once your order ships.</p>
    </div>
    <div class="footer">
        &copy; <?= date('Y') ?> Brewhub. All rights reserved.
    </div>
</div>
</body>
</html>
