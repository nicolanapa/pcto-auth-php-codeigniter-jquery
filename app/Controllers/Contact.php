<?php

namespace App\Controllers;

class Contact extends BaseController {
    public function index() {
        return view("partials/head", ["title" => "Contact"])
            . view("contact")
            . view("partials/foot");
    }
}
