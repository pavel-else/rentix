<?php

function isUniq($value, $tablename, $fieldname = 'id_rent')
{
    require_once("../libs/db.php");
    $pDB = rent_connect_DB();

    if (!$tablename) {
        return false;
    }

    $sql = "
        SELECT `$fieldname` 
        FROM `$tablename`
        WHERE `$fieldname` = :value
    ";
    $d = array(
        'value' => $value
    );

    $result = $pDB->get($sql, 0, $d);

    return !$result;
}