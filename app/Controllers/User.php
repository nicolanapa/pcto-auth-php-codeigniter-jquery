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

    private function validateUserData($data, $type, $name) {
        if ($this->validateData($data, $type === "username"
            ? [$name => "required|min_length[4]|max_length[128]"]
            : ($type === "boolean" ? [$name => "is_bool"] : ""))) {
            return true;
        } else {
            $this->response->setStatusCode(400);

            return false;
        }
    }

    public function put($userId) {
        $data = $this->request->getRawInputVar(["username", "is_admin", "can_access"]);

        if (isset($data["username"])) {
            $this->validateUserData($data, "username", "username");
        } else if (isset($data["is_admin"])) {
            $this->validateUserData($data, "boolean", "is_admin");
        } else if (isset($data["can_access"])) {
            $this->validateUserData($data, "boolean", "can_access");
        } else {
            $this->response->setStatusCode(400);
        }

        $user = $this->validator->getValidated();
        $user["id"] = $userId;

        return $this->response->setJSON(body: [
            "status" => $this->response->getStatusCode(),
            "data" => $user,
            "errors" => $this->validator->getErrors()
        ]);
    }

    public function delete($userId) {
    }
}
