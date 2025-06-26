<?php

namespace App\Controllers;

use App\Models\User;

class AuthenticationPage extends BaseController {
    protected $helpers = ["form"];
    protected $userRule = [
        "username" => [
            "rules" => "required|min_length[4]|max_length[128]",
            "errors" => [
                "required" => "An username is required",
                "min_length" => "An username can't be less than 4 chars length",
                "max_length" => "An username can't be more than 128 chars length"
            ]
        ],
        "password" => [
            "rules" => "required|min_length[2]|max_length[256]",
            "errors" => [
                "required" => "A password is required",
                "min_length" => "A password can't be less than 2 chars length",
                "max_length" => "A password can't be more than 256 chars length"
            ]
        ],
    ];

    public function loginView() {
        helper("form");

        return view("partials/head", ["title" => "Login Page"])
            . view("partials/loginForm")
            . view("partials/foot");
    }

    public function login() {
        $data = $this->request->getPost(["username", "password"]);

        if (!$this->validateData(
            $data,
            $this->userRule
        )) {
            return view("partials/head", ["title" => "Login Page"])
                . view("partials/loginForm", ["errors" => $this->validator->getErrors()])
                . view("partials/foot");
        }

        $model = model(User::class);

        $user = $this->validator->getValidated();

        if ($model->checkPassword($user)) {
            return redirect("/reservedPage/normal");
        } else {
            return view("partials/head", ["title" => "Login Page"])
                . view("partials/loginForm", ["errors" => "Username might not exist or password is wrong"])
                . view("partials/foot");
        }
    }

    public function signupView() {
        helper("form");

        return view("partials/head", ["title" => "Signup Page"])
            . view("partials/signupForm")
            . view("partials/foot");
    }

    public function signup() {
        $data = $this->request->getPost(["username", "password", "is_admin"]);

        if (!$this->validateData(
            $data,
            $this->userRule,
            [
                "is_admin" => [
                    "rules" => "matches[true]",
                    "errors" => ["matches" => "Is Admin checkbox checked value must be 'true'"]
                ]
            ]
        )) {
            return view("partials/head", ["title" => "Signup Page"])
                . view("partials/signupFOrm", ["errors" => $this->validator->getErrors()])
                . view("partials/foot");
        }

        $model = model(User::class);

        $user = $this->validator->getValidated();

        if (!isset($user["is_admin"])) {
            $user["is_admin"] = false;
        }

        if ($model->postUser($user)) {
            return redirect("/reservedPage/normal");
        } else {
            return view("partials/head", ["title" => "Signup Page"])
                . view("partials/signupForm", ["errors" => "Username might not exist or password is wrong"])
                . view("partials/foot");
        }
    }
}
