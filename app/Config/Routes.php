<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Product::index');
$routes->get('testdb', 'TestDb::index');
$routes->get('product', 'Product::index');
$routes->get('product/getAll', 'Product::getAll');
$routes->post('product/create', 'Product::create');
$routes->delete('product/delete/(:num)', 'Product::delete/$1');
$routes->post('/product/update/(:num)', 'Product::update/$1');

