<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Home;
use App\Controllers\About;
use App\Controllers\Contact;
use App\Controllers\AuthenticationPage;
use App\Controllers\ReservedPage;
use App\Controllers\User;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, "index"]);
$routes->get("/about", [About::class, "index"]);
$routes->get("/contact", [Contact::class, "index"]);

$routes->get("/login", [AuthenticationPage::class, "loginView"]);
$routes->post("/login", [AuthenticationPage::class, "login"]);
$routes->get("/signup", [AuthenticationPage::class, "signupView"]);
$routes->post("/signup", [AuthenticationPage::class, "signup"]);
$routes->post("/logout", [AuthenticationPage::class, "logout"]);

$routes->get("/reservedPage/normal", [ReservedPage::class, "normalUser"]);
$routes->get("/reservedPage/admin", [ReservedPage::class, "adminUser"]);

// REST API Routes
$routes->get("/user", [User::class, "getAll"]);
$routes->post("/user", [User::class, "post"]);
$routes->get("/user/(:num)", [User::class, "get"]);
$routes->put("/user(:num)", [User::class, "put"]);
$routes->delete("/user(:num)", [User::class, "delete"]);
