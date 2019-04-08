<?php

trait Categories
{
    private function getCategories() {
        /*
        * Функция Выбирает категории из БД
        */
        $sql = '
            SELECT * 
            FROM `products`
            WHERE `id_rental_org` IN (
                SELECT `id_rent`
                FROM `rental_points`
                WHERE `id_rental_org` = :id_rental_org
            )
        ';
        $sql = '
            SELECT * 
            FROM `categories` 
            WHERE `id_rental_org` IN (
                SELECT `id_rent`
                FROM `rental_points`
                WHERE `id_rental_org` = :id_rental_org
            )
        ';

        $d = array(
            'id_rental_org' => $this->org_id
        );

        return $this->pDB->get($sql, 0, $d);
    }

    private function newCategory($value) {
        $name = $value[name];
        $appId = $value[appId];

        $idRent = $this->getIdRent('categories', $appId);

        $sql = '
            INSERT INTO `categories` (
            `id`,
            `id_rent`,
            `id_rental_org`,
            `name`,
            `updated`,
            `created`
        ) VALUES (
            NULL,
            :id_rent,
            :id_rental_org,
            :name,
            :updated,
            :created
        )';

        $d = array(
            'id_rent'       => $idRent,
            'id_rental_org' => $appId,
            'name'          => $name,
            'updated'       => date("Y-m-d H:i:s"),
            'created'       => date("Y-m-d H:i:s")
        );

        $result = $this->pDB->set($sql, $d);

        $log = $result ? 
            'newCategory completed!':
            'newCategory failed!';            

        $this->writeLog($log);

        return $result;
    }
}
