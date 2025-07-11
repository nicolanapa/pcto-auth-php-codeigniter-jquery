<?php

namespace App\Controllers;

use App\Libraries\UserSession;
use App\Models\User;
use App\Models\Image;

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

        return view("partials/head", [
            "title" => "Login Page",
            "stylesheets" => ["authenticationPage.css"]
        ])
            . view("partials/loginForm")
            . view("partials/foot");
    }

    public function login() {
        $data = $this->request->getPost(["username", "password"]);

        if (!$this->validateData(
            $data,
            $this->userRule
        )) {
            return view("partials/head", [
                "title" => "Login Page",
                "stylesheets" => ["authenticationPage.css"]
            ])
                . view("partials/loginForm", ["errors" => $this->validator->getErrors()])
                . view("partials/foot");
        }

        $model = model(User::class);

        $user = $this->validator->getValidated();

        if ($model->checkPassword($user)) {
            $fetchedUser = $model->getUserFromName($user["username"]);

            if (!isset($fetchedUser)) {
                return view("partials/head", [
                    "title" => "Login Page",
                    "stylesheets" => ["authenticationPage.css"]
                ])
                    . view("partials/loginForm", ["errors" => [
                        "unknown_error" => "DB may have failed or some unknown Error has happened"
                    ]])
                    . view("partials/foot");
            }

            new UserSession()->setSession($fetchedUser);

            if ($fetchedUser["can_access"]) {
                return redirect()->to("/reservedPage/" . ($fetchedUser["is_admin"] ? "admin" : "normal"));
            } else {
                return redirect()->to("/");
            }
        } else {
            return view("partials/head", [
                "title" => "Login Page",
                "stylesheets" => ["authenticationPage.css"]
            ])
                . view("partials/loginForm", ["errors" => [
                    "username_password" => "Username might not exist or password is wrong"
                ]])
                . view("partials/foot");
        }
    }

    public function signupView() {
        helper("form");

        return view("partials/head", [
            "title" => "Signup Page",
            "stylesheets" => ["authenticationPage.css"]
        ])
            . view("partials/signupForm", ["signupMode" => true])
            . view("partials/foot");
    }

    public function signup() {
        $data = $this->request->getPost(["username", "password", "is_admin", "can_access", "image"]);

        $data["is_admin"] = isset($data["is_admin"]) ?
            ($data["is_admin"] === "true" || $data["is_admin"] ?
                true : false) : false;

        $data["can_access"] = isset($data["can_access"]) ?
            ($data["can_access"] === "true" || $data["can_access"] ?
                true : false) : false;

        if (!$this->validateData(
            $data,
            [
                ...$this->userRule,
                "is_admin" => [
                    "rules" => "is_bool",
                    "errors" => ["is_bool" => "Is Admin checkbox checked value must be 'true'"]
                ],
                "can_access" => [
                    "rules" => "is_bool",
                    "errors" => ["is_bool" => "Can Access checkbox checked value must be 'true'"]
                ],
                "image" => [
                    "rules" => [
                        "is_image[image]",
                        "mime_in[image,image/jpg,image/jpeg,image/gif,image/png,image/webp,image/svg]",
                        "max_size[image,10000]",
                        "max_dims[image,3840,2160]",
                    ],
                    "errors" => ["" => ""]
                ]
            ]
        )) {
            return view("partials/head", [
                "title" => "Signup Page",
                "stylesheets" => ["authenticationPage.css"]
            ])
                . view(
                    "partials/signupForm",
                    [
                        "errors" => $this->validator->getErrors(),
                        "signupMode" => true
                    ]
                )
                . view("partials/foot");
        }

        $image = $this->request->getFile("image");
        $imageId = 1;
        if (!$image->hasMoved()) {
            $imageName = $image->getRandomName();

            $image->move("./userImages/", $imageName);

            $imageModel = new Image();
            $postedId = $imageModel->postImage("./$imageName");

            if ($postedId !== 0) {
                $imageId = $postedId;
            }
        }

        $model = model(User::class);

        $user = $this->validator->getValidated();
        $user["image_id"] = $imageId;
        // Add Image to DB and get id of it
        // Add it to $user as "image_id"

        if ($model->postUser($user)) {
            $fetchedUser = $model->getUserFromName($user["username"]);
            new UserSession()->setSession($fetchedUser);

            if (!isset($fetchedUser)) {
                return view("partials/head", [
                    "title" => "Signup Page",
                    "stylesheets" => ["authenticationPage.css"]
                ])
                    . view("partials/signupForm", [
                        "errors" => [
                            "unknown_error" => "DB may have failed or some unknown Error has happened"
                        ],
                        "signupMode" => true
                    ])
                    . view("partials/foot");
            }

            if ($fetchedUser["can_access"]) {
                return redirect()->to("/reservedPage/" . ($fetchedUser["is_admin"] ? "admin" : "normal"));
            } else {
                return redirect()->to("/");
            }
        } else {
            return view("partials/head", [
                "title" => "Signup Page",
                "stylesheets" => ["authenticationPage.css"]
            ])
                . view("partials/signupForm", [
                    "errors" => [
                        "username_password" => "Username might not exist or password is wrong"
                    ],
                    "signupMode" => true
                ])
                . view("partials/foot");
        }
    }

    public function logout() {
        new UserSession()->removeSession();

        return redirect("/");
    }
}
