<?php
    class databaseHandler {
        private $mysqli = null;
        private static $databaseHandler = null;

        private function databaseHandler () {
        }

        public static function getInstance ($host, $user, $password, $database) {
        	if (empty(self::$databaseHandler)) {
        		self::$databaseHandler = new databaseHandler($host, $user, $password, $database);
        		self::$databaseHandler->mysqli = new mysqli($host, $user, $password, $database);
        		if (self::$databaseHandler->mysqli->connect_errno) {
        			syslog(0, "Failed to connect to MySQL: (" . self::$databaseHandler->connect_errno . ") " . self::$databaseHandler->connect_error);
        		}
        	}

           return self::$databaseHandler;
        }

        public function select ($table, $columns, $where) {
            $output = [];
            $sql = 'SELECT animals.name, birthday, sexes.description as sex, c1.description as eyeColour, c2.description as furColour, species.description as species,
                    species.code as speciesCode
                    FROM '.$table.'
                        JOIN animals USING (animal)
                        JOIN species USING (species)
                        JOIN sexes USING (sex)
                        JOIN colours c1 ON animals.furColour = c1.colour
                        JOIN colours c2 ON animals.eyeColour = c2.colour
                    WHERE id = 1;';

            $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $output[$key][] = $value;
                }
            }

            return $output;
        }

        public function getLastInsertId () {
            $insertId = null;
            $sql = 'SELECT LAST_INSERT_ID() as insertId;';

            $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_assoc()) {
                $insertId = $row['insertId'];
            }

            return $insertId;
        }

        public function query ($sql) {
            return $this->mysqli->query($sql);
        }
    }
?>