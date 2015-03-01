<?php
    class race {
        private $race = null;
        private $code = null;
        private $name = null;

        public function race () {
            
        }

        /**
         * @param int $id
         */
        public static function getFromDb ($id) {
            $raceDb = null;

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    races
                    WHERE race = '.$id.';';
            $result = $db->query($sql);

            if ($row = $result->fetch_assoc()) {
                $raceDb = new race();
                $raceDb->sex  = $row['sex'];
                $raceDb->code = $row['code'];
                $raceDb->name = $row['name'];
            }
            return $raceDb;
        }

        public static function getRaces () {
            $races = [];

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    races;';
            $result = $db->query($sql);

            while ($row = $result->fetch_assoc()) {
                $races[] = ['code' => $row['code'],
                            'name' => $row['name']];
            }
            return $races;
        }

        public function getRace () {
            return $this->sex;
        }

        public function getCode () {
            return $this->code;
        }

        public function getName () {
            return $this->name;
        }
    }