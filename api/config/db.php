<?php
require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;


$local = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

if ($local) {
    // Configuração para XAMPP
    $config = [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => '', 
        'username'  => 'root',
        'password'  => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ];
} else {
    // Configuração para Hostinger
    $config = [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => '',     
        'username'  => '',       
        'password'  => '',     
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ];
}

$capsule->addConnection($config);
$capsule->setAsGlobal();
$capsule->bootEloquent();
