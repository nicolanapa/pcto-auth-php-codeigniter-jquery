<?php

namespace App\Controllers;

use App\Libraries\UserSession;
use App\Models\User;
use App\Libraries\CheckPermissions;
use App\Models\Image;

class EditAll extends BaseController {
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

    public function view($id) {
        if (!CheckPermissions::userType("adminUser")) {
            $this->response->setStatusCode(403);

            return redirect()->to("/");
        }

        $user = new User()->getUser($id);

        if (!isset($user)) {
            redirect("/");
        }

        return view("partials/head", [
            "title" => "Edit Page",
            "stylesheets" => ["authenticationPage.css"]
        ])
            . view("partials/signupForm", ["signupMode" => false, "user" => $user])
            . view("partials/foot");
    }

    public function post($id) {
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
            return redirect()->to("/editAll/$id");
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
        $user["id"] = $id;
        $user["image_id"] = $imageId;

        if ($model->putUser($user)) {
            return redirect()->to("/reservedPage/admin");
        } else {
            return redirect()->to("/editAll/$id");
        }
    }
}
