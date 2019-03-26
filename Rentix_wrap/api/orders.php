<?php

trait Orders
{
    private function getOrders()
    {
        $sql = '
            SELECT * 
            FROM `orders` 
            WHERE `status` = :status  
            AND `id_rental_org` = :id_rental_org
        ';

        $d = array (
            'status'        => 'ACTIVE',
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getOrders completed" : "getOrders failed";

        $this->writeLog($log);

        return $result;
    }

    private function newOrder($order)
    {

        $checkID = function ($id_rent) {
            $sql = '
                SELECT `id` 
                FROM `orders` 
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

        $newOrder = function ($order) {           

            $sql = 'INSERT INTO `orders` (
                `id`,
                `id_rent`,
                `order_id_position`,
                `id_rental_org`,
                `status`,
                `customer_id`,
                `customer_name`,
                `start_time`,
                `advance`,
                `deposit`,
                `note`,
                `promotion`
            ) VALUES (
                NULL, 
                :id_rent, 
                :order_id_position, 
                :id_rental_org, 
                :status, 
                :order_customer_id, 
                :order_customer_name, 
                :order_start_time,
                :order_advance,
                :deposit, 
                :order_note,
                :promotion
            )';

            $d = array(
                'id_rent'            => $order[id_rent],
                'order_id_position'   => $order[order_id_position],
                'id_rental_org'       => $this->app_id,
                'status'              => $order[status],
                'order_customer_id'   => $order[customer_id],
                'order_customer_name' => $order[customer_name],
                'order_start_time'    => date("Y-m-d H:i:s", $order[start_time] / 1000),
                'order_advance'       => $order[advance] === NULL ? 0 : $order[advance],
                'deposit'             => $order[deposit],
                'order_note'          => $order[note],
                'promotion'           => $order[promotion]
            );

            return $this->pDB->set($sql, $d);
        };

        $result = !$checkID($order[id_rent]) ? $newOrder($order) : false;

        if ($result) {
            $this->writeLog('newOrder completed');
        } else {
            $this->writeLog('newOrder failed');
        }

        return $result;
    }

    private function changeOrder($order)
    {
        
        $checkID = function ($id_rent) {
            $sql = '
                SELECT `id` 
                FROM `orders` 
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

        $update = function($id, $order) {

            $sql = '
                UPDATE 
                    `orders` 
                SET 
                    `id_rent`          = :id_rent,
                    `order_id_position` = :order_id_position,
                    `id_rental_org`     = :id_rental_org,
                    `status`            = :status,
                    `customer_id`       = :customer_id,
                    `customer_name`     = :customer_name,
                    `advance`           = :advance,
                    `deposit`           = :deposit,      
                    `note`              = :note,     
                    `promotion`         = :promotion
                WHERE 
                    `id` = :id 
                AND 
                    `id_rental_org` = :id_rental_org
            ';

            $d = array(
                'id'                => $id,
                'id_rent'          => $order[id_rent],
                'order_id_position' => $order[order_id_position],
                'id_rental_org'     => $this->app_id,
                'status'            => $order[status],
                'customer_id'       => $order[customer_id],
                'customer_name'     => $order[customer_name],
                'advance'           => $order[advance],
                'deposit'           => $order[deposit],      
                'note'              => $order[note],     
                'promotion'         => $order[promotion]
            );

            return $this->pDB->set($sql, $d);
        };

        $id = $checkID($order[id_rent]);

        $result = $id ? $update($id, $order) : false;

        $log = $result ? 'changeOrder completed' : 'changeOrder failed';

        $this->writeLog($log);

        return $result;
    }

    private function deleteOrder($id_rent)
    {

        if (empty($id_rent)) {
            return false;
        }

        $cheack = function ($id_rent) {
            //Вернет true если в ордере есть активные товары или false иначе
            $sql = '
                SELECT `id` 
                FROM `sub_orders` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `id_rent` = :id_rent
                AND `status`   = :status
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id_rent'      => $id_rent,
                'status'        => 'ACTIVE',
            );

            $result = $this->pDB->get($sql, 0, $d);

            $log = $result 
                ? 'При попытке удалить ордер найдены активные сабордеры' 
                : 'При попытке удалить ордер активные сабордеры найдены не были';

            $this->writeLog($log);

            return $result;
        };

        $search = function ($id_rent) {
            $sql = '
                SELECT `id` 
                FROM `orders` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `id_rent`        = :id_rent
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id_rent'      => $id_rent
            );

            $result = $this->pDB->get($sql, 0, $d);

            return $result[0][id];
        };

        $delete = function ($id) {
            $sql = '
                DELETE FROM `orders` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `id`              = :id
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id' => $id
            );

            return $this->pDB->set($sql, $d);

        };

        // Если нет активных ордеров
        $result = $cheack($id_rent)
            ? false
            : $delete($search($id_rent));          

           
        $log = $result ? "deleteOrder completed." : "deleteOrder failed.";

        $this->writeLog($log);

        return $result;        
    }

    private function splitOrder($data)
    {   
        if (empty($data)) {
            return false;
        }

        $order = $data[order];
        $oldSubOrder = $data[subOrder];
        $newSubOrder = $data[subOrder];

        $newSubOrder[order_id] = $order[id_rent];

        $this->newOrder($order);
        $this->deleteSubOrder($oldSubOrder);
        $this->newSubOrder($newSubOrder);
        $this->deleteOrder($order[old_id]);
    }     

    // stopOrder in SubOrders
}
