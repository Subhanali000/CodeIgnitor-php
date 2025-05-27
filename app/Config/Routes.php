<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// User Routes
$routes->get('users', 'UserController::index'); 
$routes->get('users/create', 'UserController::create'); 
$routes->post('users/store', 'UserController::store'); 

// Edit Routes
$routes->get('users/edit/(:segment)', 'UserController::edit/$1'); 
$routes->post('users/update/(:segment)', 'UserController::update/$1'); 

// Delete Route
$routes->post('users/delete/(:segment)', 'UserController::delete/$1'); 
