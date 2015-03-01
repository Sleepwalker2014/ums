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
            $result = $db->query($sql);

            if ($row = $result->fetch_assoc()) {
                $notification = new notification();
                $notification->animal       = $row['animal'];
                $notification->creationDate = $row['creationDate'];
                $notification->description  = $row['description'];
            }

            return $notification;
        }

        /**
         * @return mixed[] $output
         */
        public static function getAllMarkerInformation () {
            $output = [];

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT latitude, longitude, id, s.code as species
                    FROM
                    notifications
                    JOIN animals USING (animal)
                    JOIN species s USING (species);';
            $result = $db->query($sql);

            while ($row = $result->fetch_assoc()) {
                $output[$row['id']] = ['latitude'  => $row['latitude'],
                                       'longitude' => $row['longitude'],
                                       'image'     => 'public/images/'.$row['species'].'.png'];
            }

            echo json_encode($output);
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

        public function persist () {
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'INSERT INTO 
                    notifications
                    VALUES (-34.397, 1, "2015-02-12", "mua", 1, 140.544)
                    JOIN animals USING (animal)
                    JOIN species s USING (species);';
            $result = $db->query($sql);
        }
    }