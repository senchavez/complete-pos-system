<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->get('/', 'AuthController::index');
$routes->match(['get','post'], 'login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->resource('products', ['controller' => 'ProductsController', 'except' => 'show']);
    $routes->resource('customers', ['controller' => 'CustomersController', 'except' => 'show']);
    $routes->resource('users', ['controller' => 'UsersController', 'except' => 'show']);
    $routes->get('sales', 'SalesController::index');
    $routes->match(['get','post'], 'sales/create', 'SalesController::create');
});
