<?php

trait Tariffs
{
    private function getTariffs() 
    {
        $sql = '
            SELECT * 
            FROM `tariffs`
            WHERE `id_rental_org` IN (
                SELECT `id_rent`
                FROM `rental_points`
                WHERE `id_rental_org` = :id_rental_org
            )
        ';

        $d = array (
            'id_rental_org' => $this->org_id
        );

        $result = $this->pDB->get($sql, false, $d);

        $log = $result ? "getTariffs completed" : "getTariffs failed";

        $this->writeLog($log);

        return $result;
    }
}
