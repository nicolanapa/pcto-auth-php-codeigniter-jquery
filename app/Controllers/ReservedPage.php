<?php

namespace App\Controllers;

use App\Libraries\UserSession;
use App\Models\User;

class ReservedPage extends BaseController {
    protected $user;

    public function normalUser() {
        $sessionHandler = new UserSession();

        if (!$sessionHandler->checkIfExists()) {
            return redirect()->to("/");
        }

        $this->user = $sessionHandler->getSession();

        if (isset($this->user) && isset($this->user["is_admin"]) && isset($this->user["can_access"])) {
            if ($this->user["can_access"] !== "1") {
                return redirect()->to("/");
            }
        }

        $users = new User()->getUsers();

        return view("partials/head", ["title" => "Normal User Reserved Page"])
            . view("reservedPage", ["users" => $users, "isAdmin" => false])
            . view("partials/foot");
    }

    public function adminUser() {
        $sessionHandler = new UserSession();

        if (!$sessionHandler->checkIfExists()) {
            return redirect()->to("/");
        }

        $this->user = $sessionHandler->getSession();

        if (isset($this->user) && isset($this->user["is_admin"]) && isset($this->user["can_access"])) {
            if ($this->user["is_admin"] !== "1" || $this->user["can_access"] !== "1") {
                return redirect()->to("/");
            }
        } else {
            return redirect()->to("/");
        }

        $users = new User()->getUsers();

        return view("partials/head", ["title" => "Admin User Reserved Page"])
            . view("reservedPage", ["users" => $users, "isAdmin" => true])
            . view("partials/foot");
    }
}
