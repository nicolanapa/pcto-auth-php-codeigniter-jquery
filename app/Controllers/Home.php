<?php

namespace App\Controllers;

class Home extends BaseController {
    public function index(): string {
        return view("partials/head", ["title" => "Home"])
            . view("home")
            . view("partials/foot");
    }
}
