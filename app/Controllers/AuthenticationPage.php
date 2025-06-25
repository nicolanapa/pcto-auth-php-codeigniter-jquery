<?php

namespace App\Controllers;

use App\Models\User;

class AuthenticationPage extends BaseController {
    public function loginView() {
        helper("form");

        return view("partials/head", ["title" => "Login Page"])
            . view("partials/loginForm")
            . view("partials/foot");
    }

    public function login() {
        $data = $this->request->getPost(["username", "password"]);

        // validate

        $model = model(User::class);

        // $user = $this->validator->getValidated();

        $model->checkPassword($data /* $user */);
    }

    public function signupView() {
        helper("form");

        return view("partials/head", ["title" => "Signup Page"])
            . view("partials/signupForm")
            . view("partials/foot");
    }

    public function signup() {
        $data = $this->request->getPost(["username", "password", "is_admin"]);

        // validate

        $model = model(User::class);

        // $user = $this->validator->getValidated();

        $model->postUser($data /* $user */);

        echo 1;

        return "";
    }
}
