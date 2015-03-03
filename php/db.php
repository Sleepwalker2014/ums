<?php
class db {

    public static function getIdByCode ($code, $codeField, $tableName, $idField) {
        $sql = 'SELECT '.$idField.'
                FROM '.$tableName.'
                WHERE '.$codeField.' = "'.mysql_escape_string($code).'";';
        $db = databaseHandler::getInstance ('localhost', 'root', 'Deutschrock1', 'animal');

        $result = $db->query($sql);
        while ($row = $result->fetch_assoc()) {
            return $row[$idField];
        }
    }
}