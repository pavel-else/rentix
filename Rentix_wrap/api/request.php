<?php
error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Europe/Moscow');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

require_once ('./base/logs.php');

require_once ('./low/products.php');
require_once ('./low/categories.php');
require_once ('./low/customers.php');
require_once ('./low/subOrders.php');
require_once ('./low/orders.php');
require_once ('./low/accessories.php');
require_once ('./low/auth.php');
require_once ('./low/tariffs.php');
require_once ('./low/rentalPointInfo.php');
require_once ('./low/generalSettings.php');
require_once ('./low/repairs.php');
require_once ('./low/repairTypes.php');

class Request    
{
    use Auth;    
    use Orders;    
    use SubOrders;    
    use Products;    
    use Customers;    
    use Tariffs;    
    use Accessoriess;    
    use Logs;       
    use Categories;
    use RentalPointInfo;
    use GeneralSettings;
    use Repairs;
    use RepairTypes;

    public $logs = [];
    private $response;
    private $dataJSON;
    private $app_id;
    private $pDB;
    private $token;

    public function __construct($token = null, $queue = null)
    {
        $this->token = $token;
        $this->app_id = $this->verifyToken($token);
        $this->queue = $queue;
    }
    
    private function verifyToken($token)
    {
        $pDB = $this->rent_connect_DB();
        $sql = '
            SELECT * 
            FROM `rental_points` 
            WHERE `token` = :token
        ';
        $d = array(
            'token' => $token
        );
        $result = $pDB->get($sql, 0, $d);
        $log = $result ? 'token is verify' : 'token is not verify';
        $this->writeLog($log);
        return $result[0]['id_rent'];
    }
    
    public function response()
    {
        /*
        *   1. Подключаемся к БД
        *   2. Парсим входящий запрос по отдельным командам
        *   3. По одной команде пропускаем через свитч, кот определяет какая функция обработает эту команду
        *   4. Результат своей работы каждая функция записывает в $this->response
        *   5. Массив $this->response отправляется на клиент.
        */
        $this->response  = [];
        $this->pDB = $this->rent_connect_DB();
        $switch = function ($cmd, $value) {
            switch ($cmd) {
                case 'importCustomers':
                    $this->importCustomers();
                break;

                // Auth
                case 'login':
                    $this->response['success']['token'] = $this->login($value);
                break;

                // Orders
                case 'getOrders':
                    $this->response['orders'] = $this->getOrders();
                break;
                case 'getActiveOrders':
                    $this->response['active_orders'] = $this->getActiveOrders();
                break;
                case 'newOrder':
                    $this->newOrder($value);
                break;
                case 'changeOrder':
                    $this->changeOrder($value);
                break;
                case 'deleteOrder':
                    $this->deleteOrder($value);
                break;
                case 'splitOrder':
                    $this->splitOrder($value);
                break;

                // SubOrders
                case 'getSubOrders':
                    $this->response['sub_orders'] = $this->getSubOrders();
                break;
                case 'getActiveSubOrders':
                    $this->response['active_sub_orders'] = $this->getActiveSubOrders();
                break;
                case 'getHistory':
                    $this->response['history'] = $this->getHistory($value);
                break;
                case 'newSubOrder':
                    $this->newSubOrder($value);
                break;
                case 'changeOrderProduct': //Deprecated
                    $this->changeSubOrder($value);
                break;
                case 'changeSubOrder':
                    $this->changeSubOrder($value);
                break;
                case 'deleteOrderProduct':
                    $this->deleteSubOrder($value);
                break;
                case 'stopOrder':
                    $this->stopOrder($value);
                break;
                case 'abortSubOrder':
                    $this->abortSubOrder($value);
                break;
                
                // Products
                case 'getProducts':
                    $this->response['products'] = $this->getProducts();
                break;
                case 'setProduct':
                    $this->setProduct($value);
                break;
                case 'deleteProduct':
                    $this->deleteProduct($value);
                break;
                case 'incMileage':
                    $this->incMileage($value);
                break;

                // Customers
                case 'getCustomers':
                    $this->response['customers'] = $this->getCustomers();
                break;
                case 'setCustomer':
                    $this->setCustomer($value);
                break;
                case 'deleteCustomer':
                    $this->deleteCustomer($value);
                break;
                
                // Tarifs
                case 'getTariffs':
                    $this->response['tariffs'] = $this->getTariffs();
                break;
                case 'setTariff':
                    $this->setTariff($value);
                break;
                case 'deleteTariff':
                    $this->deleteTariff($value);
                break;

                // Categories
                case 'getCategories':
                    $this->response['categories'] = $this->getCategories();
                break;

                // Accessories
                case 'getAccessories':
                    $this->response['accessories'] = $this->getAccessories();
                break;
                case 'setAccessory':
                    $this->setAccessory($value);
                break;
                case 'deleteAccessory':
                    $this->deleteAccessory($value);
                break;

                // Logs
                case 'getLogs':
                    $this->response['logs'] = $this->logs;
                break;
                case 'getHeaders':
                    $this->response['headers'] = $this->emu_getallheaders();
                break;

                // RentalPointInfo
                case 'getRentalPointInfo':
                    $this->response['rental_point_info'] = $this->getRentalPointInfo();
                break;
                case 'setRentalPointInfo':
                    $this->setRentalPointInfo($value);
                break;

                // GeneralSettings
                case 'getGeneralSettings':
                    $this->response['general_settings'] = $this->getGeneralSettings();
                break;
                case 'setGeneralSettings':
                    $this->setGeneralSettings($value);
                break;

                // Repairs
                case 'getRepairs':
                    $this->response['repairs'] = $this->getRepairs();
                break;
                case 'setRepair':
                    $this->setRepair($value);
                break;
                case 'stopRepair':
                    $this->stopRepair($value);
                break;

                // RepairTypes
                case 'getRepairTypes' :
                    $this->response['repair_types'] = $this->getRepairTypes();
                break;

                // else
                default:
                    $this->writeLog('undefined methods: ' . $cmd . ': ' . $value);
            } 
        };
        foreach ($this->queue as $key => $cell) {
            if ($cell[cmd]) {
                $switch($cell[cmd], $cell[value]);
            }
        }
        $this->getLogs();
        $this->send($this->response);
    }
    // Отправка данных клиенту
    public function send($data)
    {
        echo json_encode($data);
    }
    
    /* Функция подключения БД */
    private function rent_connect_DB()
    {
        require_once('../libs/db.php');
        $pDB = new Pdo_Db();
        $pDB->connect();
        if (!$pDB->isConnected()){
            echo "Ошибка подключения к БД";
            die();
        }
        return $pDB;
    }

    /* 
    * Общая функция поиска id_rent в указанной таблице
    * Возвращает чистый id в качестве бонуса
    */
    private function findIdRent($tableName, $id_rent)
    {
        return $this->getIdRentIn($tableName, $is_rent);
    }

    // Depricated!
    private function findIdRentIn($tableName, $id_rent)
    {
        $sql = "
            SELECT `id` 
            FROM $tableName 
            WHERE `id_rental_org` = :id_rental_org
            AND `id_rent`         = :id_rent
        ";

        $d = array(
            'id_rental_org' => $this->app_id,
            'id_rent'       => $id_rent
        );

        $result = $this->pDB->get($sql, 0, $d);

        return $result ? $result[0][id] : false;   
    }

    /*
    * Запрос БД на максимальный id_rent в таблице.
    * Возвращает увеличенный id_rent или 1 если  ничего не найдено
    */
    private function getIdRent($tableName)
    {
        return $this->getIdRentIn($tableName);
    }

    // Depricated!
    private function getIdRentIn($tableName)
    {
        $sql = "
            SELECT `id_rent` 
            FROM $tableName 
            WHERE `id_rental_org` = :id_rental_org 
            ORDER BY `id_rent`
            DESC LIMIT 1
        ";

        $d = array(
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, 0, $d);

        return $result ? ++$result[0][id_rent] : 1;    
    }

    private function getMaxIdRent($tableName) {
        $sql = "
            SELECT `id_rent` 
            FROM $tableName 
            WHERE `id_rental_org` = :id_rental_org 
            ORDER BY `id_rent`
            DESC LIMIT 1
        ";

        $d = array(
            'id_rental_org' => $this->app_id
        );

        $result = $this->pDB->get($sql, 0, $d);

        return $result ? $result[0][id_rent] : 0;         
    }
}


// Если пришла команда логина - пытаемся логинить, если да - отправляем токен
// Если приша КРУД команда - смотрим токен. Если совпадает - выполняем, если нет, то нет

$postDataJSON = file_get_contents('php://input');
$dataJSON = json_decode($postDataJSON, true);

if ($dataJSON['cmd'] === 'login') {
    $request = new Request();
    $token = $request->login($dataJSON['value']);
    $request->send(['token' => $token]);
} else if ($dataJSON['token']) {
    $request = new Request($dataJSON['token'], $dataJSON['queue']);
    $request->response();
}