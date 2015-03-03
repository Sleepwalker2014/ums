<?php
class db {

    public static function getIdByCode ($code, $codeField, $tableName, $idField) {
        $sql = 'SELECT '.$idField.'
                FROM '.$tableName.'
                WHERE '.$codeField.' = "'.mysql_escape_string($code).'";';
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

        $result = $db->query($sql);
        if ($row = $result->fetch_assoc()) {
            syslog(0, print_r($row,true));
            return $row[$idField];
        }
    }
}