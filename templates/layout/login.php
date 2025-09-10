<?php
use Cake\Core\Configure;
$appLocale = Configure::read('App.defaultLocale');
?>
<!DOCTYPE html>
<html lang="<?= $appLocale ?>">
<head>
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?> - BrewHub</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <?= $this->Html->css([
        '/vendor/fontawesome-free/css/all.min.css',
        '/css/sb-admin-2.min.css'
    ]) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="bg-gradient-primary">
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->Html->script([
    '/vendor/jquery/jquery.min.js',
    '/vendor/bootstrap/js/bootstrap.bundle.min.js',
    '/vendor/jquery-easing/jquery.easing.min.js',
    '/js/sb-admin-2.min.js'
]) ?>
<?= $this->fetch('footer_script') ?>
</body>
</html>
