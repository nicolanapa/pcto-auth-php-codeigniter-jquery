<?php

namespace App\Models;

use CodeIgniter\Model;

class Image extends Model {
    protected $table = "image";
    protected $allowedFields = ["path"];
    protected $primaryKey = "id";

    public function getImage($id) {
        return $this->select("path")->find($id)["path"];
    }

    public function postImage($path) {
        $this->save(["path" => $path]);

        return $this->getInsertID();
    }
}
