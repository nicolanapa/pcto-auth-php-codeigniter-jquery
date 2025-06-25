<?php

namespace App\Controllers;

class AuthenticationPage extends BaseController {
    public function loginView() {
        return view("partials/head", ["title" => "Login Page"])
            . view("partials/loginForm")
            . view("partials/foot");
    }

    public function login() {
        return "";
    }

    public function signupView() {
        return view("partials/head", ["title" => "Signup Page"])
            . view("partials/signupForm")
            . view("partials/foot");
    }

    public function signup() {
        return "";
    }
}
