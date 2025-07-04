<?php

namespace App\Controllers;

use App\Libraries\UserSession;
use App\Models\User;
use App\Libraries\CheckPermissions;

class ReservedPage extends BaseController {
    protected $helpers = ["url"];
    protected $user;

    public function normalUser() {
        if (!CheckPermissions::userType("normalUser")) {
            $this->response->setStatusCode(403);

            return redirect()->to("/");
        }

        $users = new User()->getUsers();

        return view("partials/head", [
            "title" => "Normal User Reserved Page",
            "scripts" => ["editX.js", "../DataTables/datatables.js"],
            "stylesheets" => ["reservedPage.css", "../DataTables/datatables.css"]
        ])
            . view("reservedPage", ["users" => $users, "isAdmin" => false])
            . view("partials/foot");
    }

    public function adminUser() {
        if (!CheckPermissions::userType("adminUser")) {
            $this->response->setStatusCode(403);

            return redirect()->to("/");
        }

        $users = new User()->getUsers();

        return view("partials/head", [
            "title" => "Admin User Reserved Page",
            "scripts" => ["editX.js", "../DataTables/datatables.js"],
            "stylesheets" => ["reservedPage.css", "../DataTables/datatables.css"]
        ])
            . view("reservedPage", ["users" => $users, "isAdmin" => true])
            . view("partials/foot");
    }
}
