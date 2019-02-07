<?php

function getID($tablename, $fieldname = 'id_rent', $f = null)
{
    $f = $f ? $f : function ($id) { return $id + 1; };

    require_once("./connectToDB.php");
    $pDB = rent_connect_DB();

    if (!$tablename) {
        return false;
    }

    $sql = "
        SELECT `$fieldname` 
        FROM `$tablename` 
    ";

    $query = $pDB->get($sql, 0, 0);
    $result = 0;

    // Выбираеи наибольший ID
    foreach ($query as $value) {
        if ($value[$fieldname] > $result) {
            $result = $value[$fieldname];
        }
    }

    return $f($result);
}