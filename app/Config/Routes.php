<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/register', 'Auth::index');
$routes->post('/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login/proccess', 'Auth::login_action');
$routes->get('/logout/user', 'Auth::logout_user');


// make a routes from 2 parameter include kategori and name of barang put in slug
$routes->get('/barang/(:any)/(:any)', 'Home::detail/$1/$2');





// Routing for Admin

$routes->get('/auth', 'AuthAdmin::index');
$routes->post('/auth', 'AuthAdmin::auth');
$routes->get('/auth/logout', 'AuthAdmin::logout');
$routes->group('admin', ['namespace' => 'App\Controller\Admin', 'filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');

    // Routing for Barang
    $routes->get('/barang', 'Barang::index');
    $routes->get('/barang/add', 'Barang::Add');
    $routes->post('/barang/add', 'Barang::Store');
    $routes->get('/barang/edit/(:num)', 'Barang::edit/$1');
    $routes->post('/barang/update/(:num)', 'Barang::update/$1');
    // make a routes for delete barang
    $routes->get('/barang/delete/(:num)', 'Barang::delete/$1');


    // Routing for Kategori 
    $routes->get('/kategori', 'Kategori::index');
    $routes->get('/kategori/add', 'Kategori::add');
    $routes->post('/kategori/add', 'Kategori::store');
    $routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
    $routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
    $routes->get('/kategori/delete/(:num)', 'Kategori::delete/$1');


    // Routing for Pengguna
    $routes->get('/pengguna', 'Pengguna::index');
    $routes->get('/pengguna/delete/(:num)', 'Pengguna::delete/$1');


    // Routing for Transaksi
    $routes->get('/transaksi', 'Transaksi::index');
    $routes->get('/transaksi/view/(:num)', 'Transaksi::view/$1');
    $routes->post('/transaksi/update/(:num)', 'Transaksi::update/$1');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
