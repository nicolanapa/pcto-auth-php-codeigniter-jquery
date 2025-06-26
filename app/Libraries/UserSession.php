<?php

namespace App\Libraries;

class UserSession {
    private $session;

    public function __construct() {
        $this->session = session();
        $this->session->start();
    }

    public function checkIfExists(): bool {
        return $this->session->has("loggedInUser");
    }

    public function getSession(): array|null {
        return $this->session->getTempdata("loggedInUser");
    }

    public function setSession($data) {
        $this->session->setTempdata("loggedInUser", $data, 900);
    }

    public function removeSession() {
        $this->session->removeTempdata("loggedInUser");
    }

    public function __destruct() {
        $this->session->close();
    }
}

new UserSession();
