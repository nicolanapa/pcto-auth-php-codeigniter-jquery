<?php

namespace App\Controllers;

use App\Libraries\UserSession;
use App\Models\User;
use App\Libraries\CheckPermissions;

class EditAll extends BaseController {
    public function view($id) {
        if (!CheckPermissions::userType("adminUser")) {
            $this->response->setStatusCode(403);

            return redirect()->to("/");
        }

        helper("form");

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
    }
}
