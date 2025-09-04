<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        ConnectionManager::get($name)->getDriver()->connect();
        // No exception means success
        $connected = true;
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
        if ($name === 'debug_kit') {
            $error = 'Try adding your current <b>top level domain</b> to the
                <a href="https://book.cakephp.org/debugkit/5/en/index.html#configuration" target="_blank">DebugKit.safeTld</a>
            config and reload.';
            if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
                $error .= '<br />You need to install the PHP extension <code>pdo_sqlite</code> so DebugKit can work properly.';
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BrewHub</title>
    <link rel="stylesheet" href="webroot/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <div class="container">
        <a href="<?= $this->Url->build('/') ?>" class="brand">BrewHub</a>
        <ul class="nav-links">
            <li><a href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'index']) ?>">Admin</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'forms', 'action' => 'add']) ?>" class="btn btn-outline">Get in Touch</a></li>
        </ul>
    </div>
</nav>


<header class="hero">
    <div class="hero-overlay">
        <h1>Welcome to <span class="highlight">BrewHub</span></h1>
        <p>Crafting coffee of outstanding quality.</p>
    </div>
</header>

<section class="features container">
    <div class="feature">
        <h2>Premium blends</h2>
        <p>Curated coffees roasted to perfection, tailored for every taste.</p>
    </div>
    <div class="feature">
        <h2>Carefully crafted</h2>
        <p>We bring a special level of passion and care to our brews.</p>
    </div>
    <div class="feature">
        <h2>Merchandise</h2>
        <p>The perfect paraphernalia to complement your cuppa your way.</p>
    </div>
</section>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> BrewHub. All Rights Reserved.</p>
</footer>
</body>
</html>
