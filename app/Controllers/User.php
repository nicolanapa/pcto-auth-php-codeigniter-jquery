<?php

namespace App\Controllers;

use App\Libraries\UserSession;
use App\Models\User as UserModel;

class User extends BaseController {
    protected $format = "json";
    private $model;

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

    private function error403() {
        $this->response->setStatusCode(403);

        return $this->response->setJSON(body: [
            "status" => $this->response->getStatusCode(),
            "errors" => "The User doesn't have enough permissions"
        ]);
    }

    private function checkPermissions() {
        $sessionHandler = new UserSession();

        if (!$sessionHandler->checkIfExists()) {
            return $this->error403();
        }

        $user = $sessionHandler->getSession();

        if (isset($user) && isset($user["is_admin"]) && isset($user["can_access"])) {
            if ($user["is_admin"] !== "1" || $user["can_access"] !== "1") {
                return $this->error403();
            } else {
                return true;
            }
        } else {
            return $this->error403();
        }
    }

    public function getAll() {
        return $this->response->setJSON(new UserModel()->getUsers());
    }

    public function post() {
        $permissions = $this->checkPermissions();
        if ($permissions !== true) {
            return $permissions;
        }
    }

    public function get($userId) {
        return $this->response->setJSON(new UserModel()->getUser($userId));
    }

    public function put($userId) {
        $permissions = $this->checkPermissions();
        if ($permissions !== true) {
            return $permissions;
        }

        $data = $this->request->getRawInputVar(["username", "is_admin", "can_access"]);
        $i = 0;

        if (isset($data["username"])) {
            $this->validateUserData($data, "username", "username");

            $i++;
        }

        if (isset($data["is_admin"])) {
            $data["is_admin"] = $data["is_admin"] === "true" ? true : false;
            $this->validateUserData($data, "boolean", "is_admin");

            $i++;
        }

        if (isset($data["can_access"])) {
            $data["can_access"] = $data["can_access"] === "true" ? true : false;
            $this->validateUserData($data, "boolean", "can_access");

            $i++;
        }

        if ($i === 0) {
            $this->response->setStatusCode(400);

            return $this->response->setJSON(body: [
                "status" => $this->response->getStatusCode(),
                "errors" => "Wrong input fields"
            ]);
        }

        $user = $this->validator->getValidated();

        $model = new UserModel();
        $userFetched = $model->getUser($userId);

        if (!isset($userFetched)) {
            $this->response->setStatusCode(404);

            return $this->response->setJSON(body: [
                "status" => $this->response->getStatusCode(),
                "errors" => "User doesn't exist"
            ]);
        }

        $model->update($userId, $user);

        return $this->response->setJSON(body: [
            "status" => $this->response->getStatusCode(),
            "errors" => $this->validator->getErrors()
        ]);
    }

    public function delete($userId) {
        $permissions = $this->checkPermissions();
        if ($permissions !== true) {
            return $permissions;
        }
    }
}
