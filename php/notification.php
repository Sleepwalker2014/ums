<?php
    class notification {
        private $latitude     = null;
        private $longitude    = null;
        private $id           = null;
        private $animal       = null;
        private $creationDate = null;
        private $description  = null;

        public function notification () {
            
        }

        public static function getFromDb ($id) {
            $notification = null;
            require 'databaseHandler.php';
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    notifications
                    WHERE id = '.$id.';';
            $result = $db->query($sql, false);

            $notification = new notification();
            $notification->animal = $result['animal'];
            $notification->creationDate = $result['creationDate'];
            $notification->description = $result['description'];
        }

        public function getAnimal ($byId = false) {
            if ($byId === true) {
                return $this->animal;
            }
        }

        public function getDisplayInformation () {
                return $this->animal;
        }
    }