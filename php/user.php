<?php
require_once 'animal.php';
class userDb {
    private $user = null;
    private $name = null;

    public function __construct ($name) {
        $this->name = $name;
    }

    /**
     * @param int $id
     */
    public static function getFromDb ($id) {
        $userDb = null;
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

        $sql = 'SELECT *
                FROM
                users
                WHERE user = '.$id.';';
        $result = $db->query($sql);

        if ($row = $result->fetch_assoc()) {
            $userDb = new userDb($row['name']);
            $userDb->setUser($row['user']);
        }

        return $userDb;
    }

    /**
     * @param int $id
     */
    public static function getUserByLogin ($name = null, $password = null) {
        $userDb = null;
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

        $sql = 'SELECT *
                FROM
                `users`
                WHERE password = "'.$password.'"
                AND name = "'.$name.'";';

        $result = $db->query($sql);

        if ($row = $result->fetch_assoc()) {
            $userDb = new userDb($row['name']);
            $userDb->setUser($row['user']);
        }

        return $userDb;
    }

    /**
     */
    public function getAnimals () {
        $animals = [];
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

        $sql = 'SELECT animal
                FROM
                animals;';

        $result = $db->query($sql);

        while ($row = $result->fetch_assoc()) {
            $animals[] = animal::getFromDb($row['animal']);
        }

        return $animals;
    }

    public function getUser () {
        return $this->user;
    }

    public function setUser ($user) {
        $this->user= $user;
    }

    public function getName () {
        return $this->name;
    }

    public function setName ($name) {
        $this->name = $name;
    }

    /**
     * @param int $id
     */
    public function persist () {
            $result = null;
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'INSERT INTO
                    animals
                    VALUES (null,"'.$this->name.'","'.$this->birthDay.'",'.$this->sex.','.
                                $this->furColour.','.$this->eyeColour.',1, 0, "'.$this->specification.'",'.$this->race.');';
            $result = $db->query($sql);

            return $db->getLastInsertId();
    }
}