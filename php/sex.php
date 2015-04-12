<?php
    class sex {
        private $sex  = null;
        private $code = null;
        private $description = null;

        public function colour () {
            
        }

        /**
         * @param int $id
         */
        public static function getFromDb ($id) {
            $sexDb = null;

            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

            $sql = 'SELECT *
                    FROM
                    sexes
                    WHERE sex = '.$id.';';
            $result = $db->query($sql);

            if ($row = $result->fetch_assoc()) {
                $sexDb = new sex();
                $sexDb->sex = $row['sex'];
                $sexDb->code   = $row['code'];
            }
            return $sexDb;
        }

        public function getSex () {
            return $this->sex;
        }

        public function getCode () {
            return $this->code;
        }

        public static function getSexes () {
            $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');
            $sexes = [];
            $sql = 'SELECT sex, description, code
                    FROM
                    sexes;';
            $result = $db->query($sql);

            while ($row = $result->fetch_assoc()) {
                $sexes[$row['code']] = ['sex' => $row['sex'],
                                        'description' => $row['description']];
            }
            return $sexes;
        }
    }