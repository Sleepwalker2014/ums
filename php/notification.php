<?php
    require_once 'animal.php';
    class notification {
        private $latitude     = null;
        private $longitude    = null;
        private $id           = null;
        private $animal       = null;
        private $creationDate = null;
        private $description  = null;

        public function notification () {
            
        }

        /**
         * @param int $id
         * 
         * @return notification $notification
         */
        public static function getFromDb ($id) {
            $notification = null;

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    notifications
                    WHERE id = '.$id.';';
            $result = $db->query($sql, false);

            $notification = new notification();
            $notification->animal       = $result['animal'];
            $notification->creationDate = $result['creationDate'];
            $notification->description  = $result['description'];

            return $notification;
        }

        public function getAnimal ($byId = false) {
            if ($byId === true) {
                return $this->animal;
            }

            return animal::getFromDb($this->animal);
        }

        public function getCreationDate () {
                return $this->creationDate;
        }

        public function getDescription () {
            return $this->description;
        }
    }