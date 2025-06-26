<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model {
    protected $table = "user";
    protected $allowedFields = ["username", "hashed_password", "is_admin"];
    protected $primaryKey = "id";

    public function getUsers() {
        return $this->findAll();
    }

    public function getUser($id) {
        return $this->select(["id", "username", "is_admin"])->find($id)[0];
    }

    public function getUserFromName($username) {
        return $this->select(["id", "username", "is_admin"])->where("username", $username)->first();
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
            "is_admin" => $data["is_admin"]
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
}
