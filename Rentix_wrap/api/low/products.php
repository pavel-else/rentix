<?php

trait Products
{
    private function getProducts()
    {
        $sql = '
            SELECT * 
            FROM `products` 
            WHERE `id_rental_org` = :id_rental_org 
            ORDER BY `name`
        ';

        $d = array (
            'id_rental_org' => $this->app_id,
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getProducts completed" : "getProducts failed";

        $this->writeLog($log);

        return $result;
    }

    // private function getAllProducts() 
    // {
    //     $sql = '
    //         SELECT * 
    //         FROM `products`
    //         WHERE `id_rental_org` IN (
    //             SELECT `id_rent`
    //             FROM `rental_points`
    //             WHERE `id_rental_org` = :id_rental_org
    //         )
    //     ';

    //     $d = array (
    //         'id_rental_org' => $this->org_id
    //     );

    //     $result = $this->pDB->get($sql, false, $d);

    //     $log = $result ? "getAllProducts completed" : "getAllProducts failed";

    //     $this->writeLog($log);

    //     return $result;
    // }

    private function setProduct($product)
    {

        $checkID = function ($id_rent) {
            $sql = '
                SELECT `id` 
                FROM `products` 
                WHERE `id_rental_org` = :id_rental_org
                AND `id_rent` = :id_rent
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id_rent' => $id_rent
            );

            $result = $this->pDB->get($sql, 0, $d);

            return $result[0][id];
        };

        $newProduct = function($product) {
            $getIdRent = function () {
                // Запрос БД на максимальный id_rent.
                // Возвращает увеличенный id_rent или 1 если таблица пуста 

                $sql = '
                    SELECT `id_rent` 
                    FROM `products` 
                    WHERE `id_rental_org` = :id_rental_org 
                    ORDER BY `id_rent`
                    DESC LIMIT 1
                ';

                $d = array(
                    'id_rental_org' => $this->app_id
                );

                $result = $this->pDB->get($sql, 0, $d);

                //$this->writeLog("getid = " . $result);

                return $result ? ++$result[0][id_rent] : 1;
            };

            $sql = '
                INSERT INTO `products` (
                `id`,
                `id_rent`,
                `id_rental_org`,
                `name`,
                `cost`,
                `status`,
                `tariff_ids`,
                `tariff_default`,
                `category`,
                `color`,
                `img`, 
                `type`,
                `size`,  
                `sex`,  
                `note`, 
                `mileage`, 
                `updated`,
                `created`
            ) VALUES (
                NULL,
                :id_rent,
                :id_rental_org,
                :name,
                :cost,
                :status,
                :tariff_ids,
                :tariff_default,
                :category,
                :color,
                :img,  
                :type,
                :size, 
                :sex, 
                :note,
                :mileage, 
                :updated,
                :created
            )';

            $d = array(
                'id_rent'       => $product[id_rent] ? $product[id_rent] : $getIdRent(),
                'id_rental_org' => $this->app_id,
                'name'          => $product[name],
                'cost'          => $product[cost],
                'status'        => $product[status],
                'tariff_ids'    => $product[tariff_ids],
                'tariff_default'=> $product[tariff_default],
                'category'      => $product[category],
                'color'         => $product[color],
                'img'           => $product[img],
                'type'          => $product[type],
                'size'          => $product[size],
                'sex'           => $product[sex] ? $product[sex] : 'unisex',
                'note'          => $product[note],
                'mileage'       => '0.0',
                'updated'       => date("Y-m-d H:i:s"),
                'created'       => date("Y-m-d H:i:s")
            );
            
            $result = $this->pDB->set($sql, $d);

            $log = $result ? 
                'function setProduct successfully completed!  New Product is saved':
                'function setProduct failed!  New Product is`t saved';            

            $this->writeLog($log);

            return $result;
        };

        $update = function ($id, $product) {
            // Функция по id обновляет соотв. запись в таблице
            
            $sql = '
                UPDATE `products` 
                SET 
                    `id_rental_org` = :id_rental_org,
                    `name`          = :name,
                    `cost`          = :cost,
                    `status`        = :status,
                    `tariff_ids`    = :tariff_ids,
                    `tariff_default`= :tariff_default,
                    `color`         = :color,
                    `img`           = :img,
                    `type`          = :type, 
                    `size`          = :size,
                    `sex`           = :sex,
                    `category`      = :category,
                    `note`          = :note,
                    `mileage`       = :mileage,
                    `updated`       = :updated
                WHERE 
                    `id` = :id
            ';

            $d = array(
                'id'            => $id,
                'id_rental_org' => $this->app_id,
                'name'          => $product['name'],
                'cost'          => $product['cost'],
                'status'        => $product['status'],
                'tariff_ids'    => $product['tariff_ids'],
                'tariff_default'=> $product['tariff_default'],
                'color'         => $product['color'],
                'img'           => $product['img'],
                'type'          => $product['type'],
                'size'          => $product['size'],
                'sex'           => $product['sex'],
                'category'      => $product['category'],
                'note'          => $product['note'],
                'mileage'       => $product['mileage'],
                'updated'       => date("Y-m-d H:i:s")
            );

            $result = $this->pDB->set($sql, $d);

            if ($result) {
                $this->writeLog("setPruduct.update completed.");
            } else {
                $this->writeLog("setPruduct.update failed.");
            }

            return $result;
        };

        $id = $checkID($product[id_rent]);

        return $id ? $update($id, $product) : $newProduct($product);       
    }

    private function deleteProduct($id_rent)
    {

        $search = function ($id_rent) {
            $sql = '
                SELECT `id` 
                FROM `products` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `id_rent` = :id_rent
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id_rent' => $id_rent
            );

            $result = $this->pDB->get($sql, 0, $d);

            return $result[0][id];
        };

        $delete = function ($id) {
            $sql = '
                DELETE FROM `products` 
                WHERE `id` = :id
            ';

            $d = array(
                'id' => $id
            );

            return $this->pDB->set($sql, $d);
        };

        if (empty($id_rent)) {
            return false;
        }

        $result = $delete($search($id_rent));    
           
        if ($result) {
            $this->writeLog("deleteProduct completed.");
        } else {
            $this->writeLog("deleteProduct failed.");
        }

        return $result;       
    }

    private function incMileage($value)
    {
        $mileage = !empty($value['mileage']) ? $value['mileage'] : NULL;
        $id_rent = !empty($value['product_id']) ? $value['product_id'] : NULL;

        if (!$mileage) {
            $this->writeLog('incMileage is failed. empty mileage. Mileage =  ' . $mileage);
            return;
        }
        if ($mileage < 0) {
            $this->writeLog('incMileage is failed. mileage < 0. Mileage =  ' . $mileage);
            return;
        }
        if (!$id_rent) {
            $this->writeLog('incMileage is failed. empty id_rent. id_rent =  ' . $id_rent);
            return;
        }

        $getCurrentMileage = function ($id_rent) {
            $sql = '
                SELECT `mileage` 
                FROM `products` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `id_rent` = :id_rent
            ';

            $d = array (
                'id_rental_org' => $this->app_id,
                'id_rent' => $id_rent
            );

            $result = $this->pDB->get($sql, false, $d);
            $this->writeLog('currentMileage' . json_encode($result));

            return $result ? $result[0]['mileage'] : false;
        };

        $update = function ($id_rent, $newMileage) {
            $sql = '
                UPDATE `products` 
                SET 
                    `mileage`       = :mileage,
                    `updated`       = :updated 
                WHERE 
                    `id_rent` = :id_rent
                AND 
                    `id_rental_org` = :id_rental_org
            ';

            $d = array(
                'id_rent'       => $id_rent,
                'id_rental_org' => $this->app_id,
                'mileage'       => $newMileage,
                'updated'       => date("Y-m-d H:i:s"),
            );

            return $this->pDB->set($sql, $d);
        };

        $currentMileage = $getCurrentMileage($id_rent);

        if (!$currentMileage) {
            $this->writeLog('don`t getted current mileage');
            return false;
        }

        $newMileage = round((float) $currentMileage + (float) $mileage, 2);
        $result = $update($id_rent, $newMileage);


        if ($result) {
            $this->writeLog("incMileage completed.");
        } else {
            $this->writeLog("incMileage failed.");
            $this->writeLog(json_encode($getCurrentMileage($id_rent)));
        }

        return $result;         
    }
}
