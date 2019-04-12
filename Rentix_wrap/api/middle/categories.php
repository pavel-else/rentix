<?php

trait Categories
{
    private function getCategories()
    {
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

    private function newCategory($value)
    {
        $name = $value[name];
        $appId = $value[appId];

        $idRent = $this->getIdRent('categories', $appId);

        $sql = '
            INSERT INTO `categories` (
            `id`,
            `id_rent`,
            `id_rental_org`,
            `name`,
            `position`,
            `updated`,
            `created`
        ) VALUES (
            NULL,
            :id_rent,
            :id_rental_org,
            :name,
            :position,
            :updated,
            :created
        )';

        $d = array(
            'id_rent'       => $idRent,
            'id_rental_org' => $appId,
            'name'          => $name,
            'position'      => 999,
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
    private function changeCategoriesTree($value)
    {
        $appId = $value[appId];
        $categories = $value[categories];

        $update = function ($category) use ($appId) {
            $sql = '
                UPDATE `categories` 
                SET 
                    `position`  = :position,
                    `parent_id` = :parent_id

                WHERE 
                    `id_rent` = :id_rent
                AND 
                    `id_rental_org` = :id_rental_org
            ';

            $d = array (
                'position'      => $category[position],
                'parent_id'     => $category[parent_id],

                'id_rent'       => $category[id_rent],
                'id_rental_org' => $appId
            );

            $result = $this->pDB->set($sql, $d);

            if (!$result) {
                $this->writeLog("setCategories failed!");
            }

            return $result;
        };

        array_map(function ($i) use ($update) {
            $update($i);
        }, $categories);
    }
    private function deleteCategory($value)
    {
        $idRent = $value[idRent];
        $appId = $value[appId];

        if (!$this->findIdRent('categories', $idRent, $appId)) {
            $this->writeLog('deleteCategory is failed. id_rent not found', $idRent, $appId);
        }

        $sql = '
            DELETE FROM `categories` 
            WHERE `id_rent` = :id_rent
            AND `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rent' => $idRent,
            'id_rental_org' => $appId
        );

        $result = $this->pDB->set($sql, $d);

        $log = $result ? 'deleteCategory compleate' : 'deleteCategory failed';

        $this->writeLog($log);

        return $result;       
    }
}
