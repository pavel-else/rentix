<?php

trait Repairs
{
    private function getRepairs() {
        $sql = '
            SELECT * 
            FROM `repairs` 
            WHERE `id_rental_org` = :id_rental_org 
        ';

        $d = array (
            'id_rental_org' => $this->app_id,
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getRepairs is completed" : "getRepairs is failed";

        $this->writeLog($log);

        return $result;
    }
    
    private function setRepair($repair) {
        $new = function($repair) {
            $sql = '
                INSERT INTO `repairs` (
                `id`,
                `id_rent`,
                `id_rental_org`,
                `product_id`, 
                `is_plan`, 
                `start_time`, 
                `mileage`, 
                `types_fix`, 
                `cost_comp`, 
                `cost_repair`, 
                `note`, 
                `end_time`, 
                `updated` 
            ) VALUES (
                NULL,
                :id_rent,
                :id_rental_org,
                :product_id, 
                :is_plan, 
                :start_time, 
                :mileage, 
                :types_fix, 
                :cost_comp, 
                :cost_repair, 
                :note, 
                :end_time, 
                :updated
            )';

            $d = array(
                'id_rent' => $this->getIdRentIn('repairs'),
                'id_rental_org' => $this->app_id,
                'product_id' => $repair['product_id'], 
                'is_plan' => $repair['is_plan'], 
                'start_time' => $repair['start_time'], 
                'mileage' => $repair['mileage'], 
                'types_fix' => $repair['types_fix'], 
                'cost_comp' => $repair['cost_comp'], 
                'cost_repair' => $repair['cost_repair'], 
                'note' => $repair['note'], 
                'end_time' => $repair['end_time'],
                'updated' => date("Y-m-d H:i:s"),
            );
            
            $result = $this->pDB->set($sql, $d);

            $log = $result ? 
                'new Repair: successfully completed!':
                'new Repair: failed!';            

            $this->writeLog($log);

            if ($result) {
                // Убрать велосипед из списка Активных
                $this->updateProductStatus($repair['product_id'], 'off');
            }

            return $result;
        };

        $update = function ($id, $product) {
            // Функция по id обновляет соотв. запись в таблице
            
            $sql = '
                UPDATE `products` 
                SET 
                    `id_rent`       = :id_rent,
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
                    `categories`    = :categories,
                    `note`          = :note,
                    `mileage`       = :mileage,
                    `updated`       = :updated 
                WHERE 
                    `id` = :id
            ';

            $d = array(
                'id'            => $id,
                'id_rent'       => $product[id_rent],
                'id_rental_org' => $this->app_id,
                'name'          => $product[name],
                'cost'          => $product[cost],
                'status'        => $product[status],
                'tariff_ids'    => $product[tariff_ids],
                'tariff_default'=> $product[tariff_default],
                'color'         => $product[color],
                'img'           => $product[img],
                'type'          => $product[type],
                'size'          => $product[size],
                'categories'    => $product[categories],
                'note'          => $product[note],
                'mileage'       => $product[mileage],
                'updated'       => date("Y-m-d H:i:s", $product[updated]),
            );

            $result = $this->pDB->set($sql, $d);

            if ($result) {
                $this->writeLog("setPruduct.update completed.");
            } else {
                $this->writeLog("setPruduct.update failed.");
            }

            return $result;
        };

        $id = $this->findIdRentIn('repairs', $product[id_rent]);

        if (!$id) {
            $this->writeLog('Repairs: id_rent is not found. Make new repair');
        } else {
            $this->writeLog('Repairs: id_rent is found. Make update this repair');
        }

        return $id ? $update($id, $repair) : $new($repair);       
    }

    private function deleteRepairs($id_rent) {

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

    private function updateProductStatus($id_rent, $status)
    {
        $sql = '
            UPDATE `products` 
            SET 
                `status` = :status
            WHERE 
                `id_rent` = :id_rent
            AND 
                `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rent' => $id_rent,
            'id_rental_org' => $this->app_id,
            'status' => $status
        );

        $result = $this->pDB->set($sql, $d);

        if ($result) {
            $this->writeLog("updatePruductStatus completed.");
        } else {
            $this->writeLog("updatePruductStatus failed.");
        }

        return $result;     
    }
}
