<?php

namespace App\Controllers;

use App\Libraries\UserSession;

class ReservedPage extends BaseController {
    protected $user;

    public function normalUser() {
        $sessionHandler = new UserSession();

        if (!$sessionHandler->checkIfExists()) {
            return redirect()->to("/");
        }

        $this->user = $sessionHandler->getSession();

        if (!isset($this->user)) {
            return redirect()->to("/");
        }

        return view("partials/head", ["title" => "Normal User Reserved Page"])
            . " NORMAL USER PAGE"
            . view("partials/foot");
    }

    public function adminUser() {
        $sessionHandler = new UserSession();

        if (!$sessionHandler->checkIfExists()) {
            return redirect()->to("/");
        }

        $this->user = $sessionHandler->getSession();

        if (isset($this->user) && isset($this->user["is_admin"])) {
            if ($this->user["is_admin"] !== "1") {
                return redirect()->to("/");
            }
        } else {
            return redirect()->to("/");
        }



        return view("partials/head", ["title" => "Admin User Reserved Page"])
            . " ADMIN USER PAGE"
            . view("partials/foot");
    }
}
