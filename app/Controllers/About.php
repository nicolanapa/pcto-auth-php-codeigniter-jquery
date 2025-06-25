<?php

namespace App\Controllers;

class About extends BaseController {
    public function index() {
        return view("partials/head", ["title" => "About"])
            . view("about")
            . view("partials/foot");
    }
}
