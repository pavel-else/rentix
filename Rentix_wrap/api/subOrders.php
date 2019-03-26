<?php

trait SubOrders
{
    private function getSubOrders()
    {
        $sql = '
            SELECT * 
            FROM `sub_orders` 
            WHERE `id_rental_org` = :id_rental_org
        ';

        $d = array (
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getSubOrders completed" : "getSubOrders failed";

        $this->writeLog($log);

        return $result;       
    }
    private function getActiveSubOrders()
    {
        $sql = '
            SELECT * 
            FROM `sub_orders` 
            WHERE `id_rental_org` = :id_rental_org
            AND `status` = "ACTIVE"
            OR `status` = "PAUSE"
        ';

        $d = array (
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, false, $d);
        
        $log = $result ? "getActiveSubOrders completed" : "getActiveSubOrders failed";

        $this->writeLog($log);

        return $result;       
    }

    // Depricated
    private function getHistory()
    {

        $getOrderProducts = function ($order_id) {
            $sql = '
                SELECT * 
                FROM `sub_orders` 
                WHERE `order_id`    = :order_id 
                AND `id_rental_org` = :id_rental_org
                OR
            ';

            $d = array (
                'order_id'      => $order_id,
                'id_rental_org' => $this->app_id           
            );

            return $this->pDB->get($sql, false, $d); 
        };

        $sql = '
            SELECT * 
            FROM `orders` 
            WHERE `id_rental_org` = :id_rental_org
            ORDER BY `orders`.`id_rent`
            DESC 
            -- LIMIT 100 
        ';  

        $d = array (
            'id_rental_org' => $this->app_id,
        );      

        $orders = $this->pDB->get($sql, false, $d);

        foreach ($orders as $key => $order) {
            $order[products] = $getOrderProducts($order[id_rent]);            
            $result[] = $order;
        }

        return $result;
    }

    // productid -> id_rent
    private function newSubOrder($subOrder)
    {
        $log = $this->scanSubOrder($subOrder);

        if ($log) {
            $this->writeLog(json_encode($log));

            return false;
        }

        $search = function ($order_id, $product_id) {
            // Запись не будет проведена если товар уже в прокате или ордера не существует

            $searchInOrderProduct = function ($product_id) {

                // вернет true если продукт свободен
                // если есть такая запись, где `end_time` IS NULL, то продукт занят, вернуть false
                $sql = '
                    SELECT `id` 
                    FROM `sub_orders` 
                    WHERE `id_rental_org` = :id_rental_org 
                    AND `status`          = :status
                ';

                $d = array(
                    'id_rental_org' => $this->app_id,
                    'status'        => $status
                );

                $result = $this->pDB->get($sql, 0, $d);

                if ($result) {
                    $this->writeLog('addSubOrder failed. free product not found');
                }

                return !$result;
            };

            $searchInOrders = function ($id_rent) {
                // вернет true если найдет ордер по id
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

                if (!$result) {
                    $this->writeLog('addSubOrder failed. Order not found');
                }

                return $result;
            };

            return $searchInOrderProduct($product_id) && $searchInOrders($order_id);
        };

        $set = function ($subOrder) {

            $sql = 'INSERT INTO `sub_orders` (
                `id`, 
                `id_rent`, 
                `order_id`, 
                `id_rental_org`, 
                `product_id`,
                `tariff_id`,
                `bill_rent`, 
                `bill_access`, 
                `accessories`,
                `sale`,
                `paid`, 
                `pause_start`,
                `pause_time`,
                `end_time`,
                `note`, 
                `status` 
            ) VALUES (
                NULL,
                :id_rent,  
                :order_id, 
                :id_rental_org, 
                :product_id,
                :tariff_id,
                :bill_rent,
                :bill_access, 
                :accessories, 
                :sale,
                :paid, 
                :pause_start,
                :pause_time,
                :end_time, 
                :note, 
                :status
            )';

            $d = array(
                'id_rent'       => $subOrder[id_rent],
                'order_id'      => $subOrder[order_id],
                'id_rental_org' => $this->app_id,
                'product_id'    => $subOrder[product_id],
                'tariff_id'     => $subOrder[tariff_id],
                'accessories'   => $subOrder[accessories],
                'bill_rent'     => $subOrder[bill_rent],
                'bill_access'   => $subOrder[bill_access],
                'sale'          => $subOrder[sale],
                'paid'          => $subOrder[paid],
                'pause_start'   => $subOrder[pause_start],
                'pause_time'    => $subOrder[pause_time],
                'end_time'      => $subOrder[end_time] ? date("Y-m-d H:i:s", $subOrder[end_time]) : NULL,
                'note'          => $subOrder[note],
                'status'        => $subOrder[status]
            );

            
            $result = $this->pDB->set($sql, $d);

            $log = $result ? 'addSubOrder complete' : 'addSubOrder failed';

            $this->writeLog($log);

            return $result;
        };

        $find = $search($subOrder[order_id], $subOrder[product_id]);


        $find ? $set($subOrder) : $this->writeLog('addSubOrder failed. Duble products or empty order');
    }

    private function scanSubOrder($subOrder)
    {
        // Функция используется при добавлении и изменении сабордера

        $log = [];

        if (empty($subOrder)) {
            $log[] = "empty product";

            return $log; // все последующие не имеют смысла
        }

        if (!$subOrder[order_id]) {
            $log[] = "empty order_id";
        }

        if (!$subOrder[product_id]) {
            $log[] = "empty product_id";
        }

        if (!$subOrder[tariff_id]) {
            $log[] = "empty tariff_id";
        }

        return $log ? $log : false;
    }

    private function changeSubOrder($subOrder)
    {
        $log = $this->scanSubOrder($subOrder);

        if ($log) {
            $this->writeLog($log);

            return false;
        }

        $search = function ($order_id, $product_id) {
            $sql = '
                SELECT `id` 
                FROM `sub_orders` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `order_id`        = :order_id 
                AND `product_id`      = :product_id 
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'order_id'      => $order_id,
                'product_id'    => $product_id
            );

            $result = $this->pDB->get($sql, 0, $d);

            return $result[0][id];
        };

        $update = function ($id, $subOrder) {

            $sql = '
                UPDATE `sub_orders` 
                SET  
                    `order_id`      = :order_id, 
                    `product_id`    = :product_id,
                    `tariff_id`     = :tariff_id,
                    `accessories`   = :accessories, 
                    `bill_rent`     = :bill_rent,
                    `bill_access`   = :bill_access,
                    `sale`          = :sale,
                    `paid`          = :paid,
                    `pause_start`   = :pause_start,
                    `pause_time`    = :pause_time,
                    `end_time`      = :end_time,
                    `note`          = :note,
                    `status`        = :status 
                WHERE
                    `id` = :id
                AND
                    `id_rental_org` = :id_rental_org
            ';

            $d = array(
                'id'            => $id,
                'id_rental_org' => $this->app_id,
                'order_id'      => $subOrder[order_id],
                'product_id'    => $subOrder[product_id],
                'tariff_id'     => $subOrder[tariff_id],
                'accessories'   => $subOrder[accessories],
                'bill_rent'     => $subOrder[bill_rent],
                'bill_access'   => $subOrder[bill_access],
                'sale'          => $subOrder[sale],
                'paid'          => $subOrder[paid],
                'pause_start'   => $subOrder[pause_start],
                'pause_time'    => $subOrder[pause_time],
                'end_time'      => $subOrder[end_time],
                'note'          => $subOrder[note],
                'status'        => $subOrder[status]
            );

            
            $result = $this->pDB->set($sql, $d);

            $log = $result ? 'changeSubOrder complete' : 'changeSubOrder failed';

            $this->writeLog($log);

            return $result;
        };

        $id = $search($subOrder[order_id], $subOrder[product_id]);


        return $id ? $update($id, $subOrder) : $this->writeLog('changeSubOrder failed. Product not define in DB');
    }

    private function deleteSubOrder($subOrder) 
    {
        // Функция используется при привязке сабордера к другому ордеру (splitOrder)
        
        if (empty($subOrder[product_id])) {
            $this->writeLog('deleteSubOrders failed! empty product_id');
            
            return false;
        }

        if (empty($subOrder[order_id])) {
            $this->writeLog('deleteSubOrders failed! empty order_id');
            
            return false;
        }

        $delete = function ($id) {
            $sql = '
                DELETE FROM `sub_orders` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `id` = :id
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'id'            => $id
            );

            $result = $this->pDB->set($sql, $d);
            $log = $result ? 'delete subOrder' : 'delete subOrder failed';
            $this->writeLog($log);

            return $result;
        };
        
        $search = function ($order_id, $product_id) {
            $sql = '
                SELECT `id` 
                FROM `sub_orders` 
                WHERE `id_rental_org` = :id_rental_org 
                AND `order_id`        = :order_id
                AND `product_id`      = :product_id 
            ';

            $d = array(
                'id_rental_org' => $this->app_id,
                'order_id'      => $order_id,
                'product_id'    => $product_id
            );

            $result = $this->pDB->get($sql, 0, $d);

            return $result[0][id];
        };

        $id = $search($subOrder[order_id], $subOrder[product_id]);

        return $id ? $delete($id) : false;
    }

    private function stopOrder($subOrder) {
        /*
        * Функция принимает 1 Товар и записывает в БД информацию о стопе
        *
        * 1. Ставим временнУю метку стопа
        * 2. Пишем стоимость
        * 3. Меняем статус продукта
        * 4. Меняем статус ордера, если активных продуктов нет
        */

        $setEndTime = function ($subOrder) {          
            $sql = '
                UPDATE 
                    `sub_orders` 
                SET 
                    `end_time` = :end_time,
                    `status`   = :status  
                WHERE 
                    `order_id` = :order_id 
                AND 
                    `product_id` = :product_id' 
            ;
            $d = array(
                'end_time'   => $subOrder[end_time], 
                'status'     => $subOrder[status],
                'order_id'   => $subOrder[order_id],
                'product_id' => $subOrder[product_id],
            );

            $result = $this->pDB->set($sql, $d);

            $log = $result ? 'stopOrder: setEndTime completed' : 'stopOrder: setEndTime error';

            $this->writeLog($log);

            return $result;
        };

        $setBill = function ($subOrder) {
            $sql = '
                UPDATE 
                    `sub_orders` 
                SET 
                    -- `bill`        = :bill, 
                    `bill_rent`   = :bill_rent, 
                    `bill_access` = :bill_access, 
                    `sale`        = :sale, 
                    `paid`        = :paid 
                WHERE 
                    `order_id` = :order_id 
                AND 
                    `product_id` = :product_id' 
            ;

            $d = array(
                'bill_rent'   => $subOrder[bill_rent],
                'bill_access' => $subOrder[bill_access],
                'sale'        => $subOrder[sale],
                'order_id'    => $subOrder[order_id],
                'product_id'  => $subOrder[product_id],
                'paid'        => $subOrder[paid],
            );

            $result = $this->pDB->set($sql, $d);

            $log = $result ? 'stopOrder: setBill completed' : 'stopOrder: setBill error';

            $this->writeLog($log);

            return $result;
        };

        $setProductStatus = function ($subOrder) {
            $sql = '
                UPDATE 
                    `products` 
                SET 
                    `status` = :status 
                WHERE 
                    `id_rent` = :id_rent' 
            ;

            $d = array(
                'status'  => 'free',
                'id_rent' => $subOrder[product_id],
            );

            $result = $this->pDB->set($sql, $d);

            $log = $result ? 'stopOrder: setProductStatus completed' : 'stopOrder: setProductStatus error';

            $this->writeLog($log);

            return $result;
        };

        $setOrderStatus = function ($subOrder) {
            /*
            * 1. Выбираем по id продукты вместе с их временными стоп-метками
            * 2. Если на всех продуктах стоят стоп-метки - меняем статус ордера
            */
            $getSubOrders = function ($order_id) {
                $sql = '
                    SELECT 
                        `order_id`, 
                        `end_time` 
                    FROM 
                        `sub_orders`
                    WHERE 
                        `order_id` = :order_id
                ';

                $d = array(
                    'order_id' => $order_id
                );

                return $this->pDB->get($sql, false, $d);               
            };

            $changeOrderStatus = function ($id_rent, array $subOrders) {
                /*
                * 1. Перебираем все сабордеры ордера
                * 2. Если среди них не нашлось активного сабордера (end_time == null), меняем статус ордера
                */

                if (empty($subOrders)) {
                    return;
                }

                $result = true;

                foreach ($subOrders as $value) {
                    if (empty($value[end_time])) {
                        $result = false;
                    }
                }  

                if ($result) {
                    $sql = '
                        UPDATE 
                            `orders` 
                        SET 
                            `status` = :status 
                        WHERE 
                            `id_rent` = :id_rent
                    ';

                    $d = array(
                        'id_rent' => $id_rent,
                        'status'   => 'END'
                    );

                    return $this->pDB->set($sql, $d);
                } 
            };
            
            $result = $changeOrderStatus($subOrder[order_id], $getSubOrders($subOrder[order_id]));

            $log = $result ? 'stopOrder: setOrderStatus completed' : 'stopOrder: setOrderStatus error';

            $this->writeLog($log);

            return $result;
        };


        $setEndTime($subOrder);
        $setBill($subOrder);
        // $setProductStatus($subOrder);
        $setOrderStatus($subOrder);
    }

    private function abortSubOrder($subOrder) {
        $id = $this->find('sub_orders', $subOrder[id_rent]);

        $result = $id ? $this->changeSubOrder($subOrder) : false;
        $log = $result ? 'subOrder is aborting' : 'abortSubOrder is failed';

        $this->writeLog($log);

        return result;
    }
}
