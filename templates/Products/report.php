<?php
/**
 * @var \Cake\Datasource\ResultSetInterface|\App\Model\Entity\Product[] $products
 * @var int $threshold
 */
$generatedAt = date('Y-m-d H:i');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Report</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #222; }
        h1 { font-size: 18px; margin: 0 0 6px; }
        .meta { font-size: 11px; margin: 0 0 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        th, td { border: 1px solid #bbb; padding: 6px 8px; vertical-align: top; }
        th { background: #eee; }
        .badge-low { color: #a00; font-weight: bold; }
        .badge-ok  { color: #087f23; font-weight: bold; }
        .small { font-size: 11px; color: #555; }
    </style>
</head>
<body>
<h1>Stock Report</h1>
<p class="meta">
    Generated: <?= h($generatedAt) ?><br>
    Low stock threshold: ≤ <?= (int)$threshold ?>
</p>

<table>
    <thead>
    <tr>
        <th style="width: 30%">Product</th>
        <th style="width: 16%">Category</th>
        <th style="width: 12%">Total Stock</th>
        <th style="width: 42%">Variants (size • SKU • stock • price)</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $p): ?>
        <?php
        $total = (int)($p->stock_effective ?? 0);
        $isLow = $total <= (int)$threshold;
        ?>
        <tr>
            <td>
                <strong><?= h($p->name) ?></strong><br>
                <span class="<?= $isLow ? 'badge-low' : 'badge-ok' ?>">
            <?= $isLow ? 'LOW STOCK' : 'OK' ?>
          </span>
            </td>
            <td><?= h($p->category) ?></td>
            <td><?= $total ?></td>
            <td class="small">
                <?php if (!empty($p->product_variants)): ?>
                    <?php foreach ($p->product_variants as $v): ?>
                        • <?= h($v->size ?: '-') ?> • <?= h($v->sku ?: '-') ?>
                        • stock: <?= (int)$v->stock ?> • price: <?= number_format((float)$v->price, 2) ?><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
