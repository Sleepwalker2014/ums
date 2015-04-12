<?php
    class colour {
        private $colour = null;
        private $code   = null;

        public function colour () {
            
        }

        /**
         * @param int $id
         */
        public static function getFromDb ($id) {
            $colourDb = null;

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    colours
                    WHERE colour = '.$id.';';
            $result = $db->query($sql, false);

            if ($row = $result->fetch_assoc()) {
                $colourDb = new colour();
                $colourDb->colour = $row['colour'];
                $colourDb->code   = $row['code'];
            }
            return $colourDb;
        }

        public function getColour () {
            return $this->colour;
        }

        public function getCode () {
            return $this->code;
        }

        public static function getAllColours () {
            $colours = [];
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');
            $sql = 'SELECT *
                    FROM
                    colours;';
            $result = $db->query($sql);

            while ($row = $result->fetch_assoc()) {
                $colours[] = ['colour' => $row['colour'],
                              'name' => $row['name']];
            }

            return $colours;
        }
    }