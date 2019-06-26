<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */


if(isset($_GET['copy'])){
    copy(__DIR__.'/.env.example', '.env');
    copy(__DIR__.'/env.example', 'env/local.env');
    copy(__DIR__.'/.env.example', 'env/production.env');
    copy(__DIR__.'/public/.htaccess', '../.htaccess');
    copy(__DIR__.'/public/robots.txt', '../robots.txt');
    echo 'success';
    die();
}


if(isset($_GET['info'])){
	phpinfo();
}

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists(__DIR__.'/'.$uri)) {
    return false;
}

require_once __DIR__.'/index.php';
