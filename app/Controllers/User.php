<?php

namespace App\Controllers;

use App\Models\User as UserModel;

class User extends BaseController {
    protected $format = "json";
    private $model;

    public function getAll() {
        return $this->response->setJSON(new UserModel()->getUsers());
    }

    public function post() {
    }

    public function get($userId) {
        return $this->response->setJSON(new UserModel()->getUser($userId));
    }

    public function put() {
    }

    public function delete() {
    }
}
