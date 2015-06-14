<?php
class session {
    public function __construct() {
        $this->startSession();
    }

    public function startSession () {
        session_start();
        return $this;
    }

    public function closeSession () {
        session_destroy();
    }

    public function setSessionUser ($user) {
        $_SESSION["user"] = $user->getUser();
    }

    public function getSessionUser () {
        if (isset($_SESSION["user"])) {
            return $_SESSION["user"];
        }

        return null;
    }
}