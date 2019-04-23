<?php

trait Products
{
    private function getProducts() 
    {
        $sql = '
            SELECT * 
            FROM `products`
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

        $log = $result ? "getProducts completed" : "getProducts failed";

        $this->writeLog($log);

        return $result;
    }

    private function updateProduct($value)
    {
        $product = $value[product];
        $appId = $value[appId];
            
        $sql = '
            UPDATE `products` 
            SET 
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
                `icon_id`       = :icon_id,
                `note`          = :note,
                `mileage`       = :mileage,
                `updated`       = :updated
            WHERE 
                `id_rent`       = :id_rent
            AND
                `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'name'          => $product[name],
            'cost'          => $product[cost],
            'status'        => $product[status],
            'tariff_ids'    => $product[tariff_ids],
            'tariff_default'=> $product[tariff_default],
            'color'         => $product[color],
            'img'           => $product[img],
            'type'          => $product[type],
            'size'          => $product[size],
            'sex'           => $product[sex],
            'category'      => $product[category],
            'icon_id'       => $product[icon_id],
            'note'          => $product[note],
            'mileage'       => $product[mileage],
            'updated'       => date("Y-m-d H:i:s"),

            'id_rent'       => $product[id_rent],
            'id_rental_org' => $appId,
        );

        $result = $this->pDB->set($sql, $d);

        if ($result) {
            $this->writeLog("updateProduct completed.");
        } else {
            $this->writeLog("updateProduct failed.", json_encode($value));
        }

        return $result;
    }

    private function deleteProduct($value)
    {
        $productId = $value[productId];
        $appId     = $value[appId];

        $sql = '
            UPDATE `products` 
            SET 
                `status`        = :status,
                `updated`       = :updated
            WHERE 
                `id_rent`       = :id_rent
            AND
                `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'status'        => 'deleted',
            'updated'       => date("Y-m-d H:i:s"),

            'id_rent'       => $productId,
            'id_rental_org' => $appId,
        );

        $result = $this->pDB->set($sql, $d);

        if ($result) {
            $this->writeLog("deleteProduct completed.");
        } else {
            $this->writeLog("deleteProduct failed.", json_encode($value));
        }

        return $result; 
    }
}
