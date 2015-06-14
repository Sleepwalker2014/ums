<?php
class sessionDb {
    private $sessionId = null;
    private $user = null;

    public function __construct ($sessionId, $user) {
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');
        start_session();
        if (!empty($_SESSION['user'])) {
            syslog(0, "user here");
        } else {
            $_SESSION["user"] = "fuck";
        }
    }

    /**
     * @param int $id
     */
    public static function getFromDb ($id) {
        $sessionDb = null;
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

        $sql = 'SELECT *
                FROM
                sessions
                WHERE session = '.$id.';';
        $result = $db->query($sql);

        if ($row = $result->fetch_assoc()) {
            $sessionDb = new sessionDb($row['sessionId'], $row['user']);
        }

        return $sessionDb;
    }

    public function getSessionId () {
        return $this->sessionId;
    }

    public function setSessionId ($sessionId) {
        $this->sessionId = $sessionId;
    }

    public function getUser () {
        return $this->user;
    }

    public function setUser ($user) {
        $this->user = $user;
    }
}