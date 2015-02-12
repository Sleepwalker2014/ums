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
            $sql = 'SELECT '.$columns.'
                    FROM '.$table.'
                        JOIN 
                    WHERE id = 1;';

            $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $output[$key][] = $value;
                }
            }

            return $output;
        }
    }
?>