<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model {
    protected $table = "user";
    protected $allowedFields = ["username", "hashedPassword", "is_admin"];
    protected $primaryKey = "id";

    public function getUsers() {
        return $this->findAll();
    }

    public function getUser($id) {
        return $this->find($id);
    }

    public function postUser($data) {
        $hashedPassword = password_hash($data["password"], PASSWORD_ARGON2ID);

        if ($this->where("username", $data["username"])->first() !== null) {
            echo "User already exists!";

            return;
        }

        $this->save([
            "username" => $data["username"],
            "hashed_password" => $hashedPassword,
            "is_admin" => $data["is_admin"]
        ]);

        echo "Created and Logged In!";
        echo "Username " . $data["username"] . " " .  $data["password"] . " " . $hashedPassword . " " . $data["is_admin"];
    }

    public function checkPassword($data) {
        if ($this->where("username", $data["username"])->first() === null) {
            echo "User doesn't exist";

            return;
        }

        if (password_verify(
            $data["password"],
            $this->select("hashed_password")->where("username", $data["username"])->first()["hashed_password"]
        )) {
            echo "1";
            
            return true;
        } else {
            echo "0";

            return false;
        }
    }
}
