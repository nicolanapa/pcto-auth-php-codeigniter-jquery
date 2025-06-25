<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Contact;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, "index"]);
$routes->get("/about", [About::class, "index"]);
$routes->get("/contact", [Contact::class, "index"]);

$routes->get("/login", ["AuthenticationPage::class", "login"]);
$routes->get("/signup", ["AuthenticationPage::class", "signup"]);

$routes->get("/reservedPage/normal", ["ReservedPage::class", "normalUser"]);
$routes->get("/reservedPage/admin", ["ReservedPage::class", "adminUser"]);

// REST API Routes
$routes->get("/user", ["User::class", "getAll"]);
$routes->post("/user", ["User::class", "newUser"]);
$routes->get("/user/(:segment)", ["User::class", "get"]);
$routes->put("/user(:segment)", ["User::class", "put"]);
$routes->delete("/user(:segment)", ["User::class", "delete"]);
