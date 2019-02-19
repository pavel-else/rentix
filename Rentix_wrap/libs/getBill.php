<?php 

function getBill($app_id, $id_rent) {
    require_once('../libs/db.php');
    $pDB = rent_connect_DB();

    // Функция выбоки сабордера из БД
    $getSubOrder = function ($id_rent) use ($pDB, $app_id) {
        $sql = '
            SELECT * 
            FROM `order_products` 
            WHERE `id_rental_org` = :id_rental_org 
            AND `id_rent` = :id_rent
        ';

        $d = array (
            'id_rental_org' => $app_id,
            'id_rent' => $id_rent
        );

        $result = $pDB->get($sql, false, $d);
        
        $log = $result ? "getSubOrder completed" : "getSubOrder failed";

        if (!$result) {
            die($log);
        }

        return $result ? $result[0] : false;
    };

    // Функция выбоки ордера из БД
    $getOrder = function ($order_id) use ($pDB, $app_id) {
        $sql = '
            SELECT * 
            FROM `orders` 
            WHERE `id_rental_org` = :id_rental_org 
            AND `order_id` = :order_id
        ';

        $d = array (
            'id_rental_org' => $app_id,
            'order_id' => $order_id
        );

        $result = $pDB->get($sql, false, $d);

        $log = $result ? "getOrder completed" : "getOrder failed";

        if (!$result) {
            die($log);
        }
        
        return $result ? $result[0] : false;
    };

    $getOptions = function () use ($pDB, $app_id) {
        $sql = '
            SELECT `id_rent`, `name`, `value`  
            FROM `options` 
            WHERE `id_rental_org` = :id_rental_org
        ';

        $d = array(
            'id_rental_org' => $app_id
        );

        $result = $pDB->get($sql, false, $d);

        $log = $result ? "getOptions completed" : "getOptions failed";

        if (!$result) {
            die($log);
        }
        
        return array_reduce($result, function ($acc, $item) {
            $acc[$item['name']] = $item['value'];
            return $acc;
        }, []);
    };

    // Функция выборки тарифа из БД
    $getTariff = function ($id_rent) use ($pDB, $app_id) {
        $sql = '
            SELECT *
            FROM `tariffs` 
            WHERE `id_rental_org` = :id_rental_org
            AND `id_rent` = :id_rent
        ';

        $d = array(
            'id_rental_org' => $app_id,
            'id_rent' => $id_rent
        );

        // Вспомогательная функция
        $filter = function ($tariffs) {
            
            // Видоизменяем расчасовку (из строки в массив)
            return array_map(function ($tariff) {
                $tariff[_h_h] = $tariff[_h_h] ? explode(',' , $tariff[_h_h]) : [];
                return $tariff;
            }, $tariffs);
        };

        $result = $pDB->get($sql, 0, $d);
        $log = $result ? "getTriff completed" : "getTariff failed";

        if (!$result) {
            die($log);
        }

        return $filter($result)[0];
    };

    // Функция выборки аксессуаров из БД
    $getAccessories = function () use ($pDB, $app_id) {
        $sql = '
            SELECT 
                `id_rent`, 
                `name`, 
                `type`, 
                `value` 
            FROM 
                `accessories` 
            WHERE 
                `id_rental_org` = :id_rental_org 
        ';

        $d = array (
            'id_rental_org' => $app_id
        );

        $result = $pDB->get($sql, false, $d);
        
        $log = $result ? "getAccessories completed" : "getAccessories failed or acessories is not exists";

        // Вспомогательная функция
        $filter = function ($accessories) {
            if (!$accessories) {
                return [];
            }
            return array_reduce($accessories, function ($acc, $item) {
                $acc[$item['id_rent']] = array (
                    'name' => $item['name'],
                    'type' => $item['type'],
                    'value' => $item['value']
                );
                return $acc;
            }, []);
        };

        return $result ? $filter($result) : false;
    };

    // Функция выборки клиента из БД
    $getCustomer = function ($id_rent) use ($pDB, $app_id) {
        $sql = '
            SELECT * 
            FROM `customers` 
            WHERE `id_rental_org` = :id_rental_org 
            AND `id_rent` = :id_rent
        ';

        $d = array (
            'id_rental_org' => $app_id,
            'id_rent' => $id_rent
        );

        $result = $pDB->get($sql, false, $d);

        $log = $result ? "getCustomer completed" : "getCustomer failed";

        return $result ? $result[0] : false; 
    };

    // Функция просчета количества времени проката
    // Товар может находиться в трех состояниях: ACTIVE || PAUSE || STOP
    // Расчеты ведутся в секундах
    $getTime = function ($order, $subOrder) {
        $status = $subOrder['status'];
        $start = strtotime($order['start_time']);
        $end = time();
        $pause = round($subOrder['pause_time'] / 1000);
        $pauseStart = round($subOrder['pause_start'] / 1000);

        switch ($status) {
            case 'ACTIVE':
                return $end - $start - $pause;

            case 'PAUSE':
                // Товар может находиться в паузе несколько раз
                // Пауза равна сумме всех времменных интервалов
                // Последний интервал вычисляется как ВремяСейчас минус ВремяСтартаПоследнейПаузы 
                $lastPause = time() - $pauseStart; // diff now - pausestart
                return $end - $start - $pause - $lastPause;

            case 'END':
                $end = strtotime($subOrder['end_time']);
                return $end - $start - $pause;
            
            default:
                return false;
        }
    };

    // Функция просчета стоимости проката
    $getBill = function ($tariff, $time, $options) {
        $d = function ($tariff, $time) {
           $days = ceil($time / (3600 * 24));

            return $days * $tariff['cost'];
        };
        $f = function ($tariff) {
            return $tariff['cost'];
        };
        $h = function ($tariff, $time) use ($options) {
            $minTime = ceil($options['rent_min_time'] / 1000);
            $hh = $tariff['_h_h'];
            $last_h = $tariff['_h_h'][0];
            $h_max = $tariff['_h_max'] > 0 ? $tariff['_h_max'] : INF;

            if ($time < 0) {
                return 0;
            }
            if ($time < $minTime) {
                return $tariff['_h_min'];
            }
            $result = 0;
            $h = $time / 3600;

            for ($i = 0; $i < floor($h); $i += 1) {
                $result += $hh[$i] ? $hh[$i] : $last_h;
                $last_h = $hh[$i] ? $hh[$i] : $last_h;

                if ($result > $h_max) {
                    return $h_max;
                }
            }

            $result += $last_h * ($h - floor($h));

            if ($result > $h_max) {
                $result = $h_max;
            } else if ($result < $tariff['_h_min']) {
                $result = $tariff['_h_min'];
            }

            return $result;
        };

        switch ($tariff['type']) {
            case 'd':
                return $d($tariff, $time);
            case 'f':
                return $f($tariff);
            case 'h':
                return $h($tariff, $time);
            
            default:
                return false;
        }
    };

    // Функция просчета стоимости аксессуаров
    $getBillAccessories = function ($subOrder, $allAccessories, $bill) {
        if (empty($subOrder['accessories']) || empty($allAccessories)) {
            return 0;
        }

        $accessories = explode(',', $subOrder['accessories']);

        // Вспомогательная функция возвращает стоимость в зависимости от типа (% || fix)
        $getBillAccessory = function ($accessory) use ($bill){
            $type = $accessory['type'];
            $value = $accessory['value'];

            if (empty($type)) {
                return false;
            }
            if ($value == 0) {
                return 0;
            }

            if ($type === '%') {
                return $bill * ($value / 100);
            }
            if ($type === 'р') {
                return (int) $value;
            }
            return $type;
        };

        return array_reduce($accessories, function ($acc, $item) use ($allAccessories, $getBillAccessory) {
            $accessory = $allAccessories[$item];
            $acc += $getBillAccessory($accessory);
            return $acc;
        }, 0);
    };

    // Функция просчета скидки
    $getSale = function ($bill, $customer) {
        $percent = !empty($customer['sale']) ? (int) $customer['sale'] : 0;

        return ($bill / 100) * $percent;
    };

    // Функция округления стоимости
    $toRoundBill = function ($bill, $options) {
        $round = $options['rent_round_bill'];
        return $round > 1 ? round($bill / $round) * $round : round($bill);
    };


    $options = $getOptions();

    $subOrder = $getSubOrder($id_rent);

    $order = $getOrder($subOrder['order_id']);

    $customer = $getCustomer($order['customer_id']);

    $tariff = $getTariff($subOrder['tariff_id']);

    $accessories = $getAccessories();

    $time = $getTime($order, $subOrder);

    $bill = $getBill($tariff, $time, $options);

    $billAccessories = $getBillAccessories($subOrder, $accessories, $bill);

    $sale = $getSale($bill, $customer);

    $roundBill = $toRoundBill($bill + $billAccessories - $sale, $options);

    return $roundBill;
}

var_dump(getBill('8800000001', '323'));