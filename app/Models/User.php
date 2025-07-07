<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model {
    protected $table = "user";
    protected $allowedFields = ["username", "hashed_password", "is_admin", "can_access", "image_id"];
    protected $primaryKey = "id";

    public function getUsers() {
        $users = $this->select(["id", "username", "is_admin", "can_access", "image_id"])->findAll();

        $imageModel = new Image();
        for ($i = 0; $i < count($users); $i++) {
            $users[$i]["image_path"] = $imageModel->getImage($users[$i]["image_id"]);
        }

        return $users;
    }

    public function getUser($id) {
        $user = $this->select(["id", "username", "is_admin", "can_access", "image_id"])->find($id);
        $user["image_path"] = new Image()->getImage($user["image_id"]);

        return $user;
    }

    public function getUserFromName($username) {
        $user = $this->select(["id", "username", "is_admin", "can_access", "image_id"])->where("username", $username)->first();
        $user["image_path"] = new Image()->getImage($user["image_id"]);

        return $user;
    }

    public function postUser($data): bool {
        $hashedPassword = password_hash($data["password"], PASSWORD_ARGON2ID);

        if ($this->where("username", $data["username"])->first() !== null) {
            echo "User already exists!";

            return false;
        }

        return $this->save([
            "username" => $data["username"],
            "hashed_password" => $hashedPassword,
            "is_admin" => $data["is_admin"],
            "can_access" => $data["can_access"],
            "image_id" => $data["image_id"] ?? "1"
        ]);
    }

    public function checkPassword($data): bool {
        if ($this->where("username", $data["username"])->first() === null) {
            echo "User doesn't exist";

            return false;
        }

        if (password_verify(
            $data["password"],
            $this->select("hashed_password")->where("username", $data["username"])->first()["hashed_password"]
        )) {
            return true;
        } else {
            return false;
        }
    }

    public function putUser($data): bool {
        $fetchedUser = $this->getUser($data["id"]);
        if (!isset($fetchedUser)) {
            return false;
        }

        if ($this->where("username", $data["username"])->first() !== null) {
            echo "Username already exists!";

            return false;
        }

        $hashedPassword = password_hash($data["password"], PASSWORD_ARGON2ID);

        return $this->update(
            $data["id"],
            [
                "username" => $data["username"],
                "hashed_password" => $hashedPassword,
                "is_admin" => $data["is_admin"],
                "can_access" => $data["can_access"],
                "image_id" => $data["image_id"] ?? "1"
            ]
        );
    }
}
