<?php
/**
 * Frontend Layout for BrewHub (Corrected Script Loading)
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        BrewHub - <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->meta('icon', 'assets/favicon.ico') ?>

    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') ?>

    <?= $this->Html->script('https://use.fontawesome.com/releases/v6.3.0/js/all.js', [
        'crossorigin' => 'anonymous',
        'block' => 'script'
    ]) ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <?= $this->Html->css(['styles']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body id="page-top">

<?= $this->element('navigation') ?>

<main>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<footer class="footer bg-black small text-center text-white-50">
    <div class="container px-4 px-lg-5">Copyright &copy; <?= date('Y') ?> BrewHub. All Rights Reserved.</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->Html->script('scripts') ?>

<?= $this->fetch('script') ?>
</body>
</html>
