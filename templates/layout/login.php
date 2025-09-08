<?php
/**
 * Login layout using SB Admin 2
 *
 * @var \App\View\AppView $this
 */
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

    <!-- Fonts and CSS -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet">
    <?= $this->Html->css([
        '/vendor/fontawesome-free/css/all.min',
        '/css/sb-admin-2'
    ]) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="bg-gradient-primary">

<?= $this->Flash->render() ?>

<?= $this->fetch('content') ?>

<!-- JS -->
<?= $this->Html->script([
    '/vendor/jquery/jquery.min',
    '/vendor/bootstrap/js/bootstrap.bundle.min',
    '/vendor/jquery-easing/jquery.easing.min',
    '/js/sb-admin-2'
]) ?>

<?= $this->fetch('footer_script') ?>
</body>
</html>
