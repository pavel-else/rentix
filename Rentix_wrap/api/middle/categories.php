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
}
