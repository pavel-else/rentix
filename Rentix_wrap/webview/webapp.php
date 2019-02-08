<html><head>
<title>Велопрокат</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="http://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>

<style>
	.flex-box {
  display: flex;
  justify-content: space-between;
}
</style>

<body>
	
<div class="container pt-3">		
			
<?PHP
date_default_timezone_set('Europe/Moscow');

$app_id = '8800000001';

$inputTel = filter_var($_REQUEST['inputTel'], FILTER_SANITIZE_STRING);
$inputFIO = filter_var($_REQUEST['inputFIO'], FILTER_SANITIZE_STRING);
$valueTel = filter_var($_REQUEST['valueTel'], FILTER_SANITIZE_STRING);

$pDB = rent_connect_DB();
	
if($inputTel){
	/* Поиск по номеру телефона */
	
	$inputTel = str_replace(" ","",$inputTel);
//$inputTel = "+7(918)278-72-26";		// На время тестов завершен
//$inputTel = "+7(938)539-48-94";		// На время тестов активен
	
	
	$sql = 'SELECT * FROM `clients` WHERE `phone` = \''.$inputTel.'\' AND `id_rental_org` = '.$app_id;		// Находим клиента по его номеру телефона
	$client = $pDB->get($sql, true, false);	
	if($client) show_rent($client, $app_id);
	else {
?>
		<form method="post">
			<div class="row">
				<div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-5 mx-auto">
					<div class="text-danger pb-2">Клиент с номером <strong><?=$inputTel?></strong> не найден. Давайте попробуем поискать по ФИО!</div>
					<input type="text" name="inputFIO" id="inputFIO" class="form-control" aria-describedby="FIOHelpBlock" placeholder="Иванов А.М.">
					<small id="FIOHelpBlock" class="form-text text-muted pb-1">
				  Введите фамилию и инициалы с которыми вы регистрировались в базе проката. Пример: <strong>Иванов А.М.</strong>
					</small>
					<div class="flex-box">
						<button type="submit" class="btn btn-primary" id="submit">Поиск</button>
						<button type="button" onclick="history.back();" class="btn btn-primary">Назад</button>
					</div>
				</div>
			</div>
		</form>

<?
	}
}
else if($inputFIO){
	/* Поиск по  фамилии и инициалам */

	$t_inputFIO = str_replace(".", " ", $inputFIO);
	$t_inputFIO = trim($t_inputFIO);
	$Arr_inputFIO = explode(" ", $t_inputFIO);
	$sql = 'SELECT * FROM `clients` WHERE `fname` = \''.$Arr_inputFIO[0].'\' AND `sname` LIKE \''.$Arr_inputFIO[1].'%\' AND `tname` LIKE \''.$Arr_inputFIO[2].'%\' AND `id_rental_org` = '.$app_id;		// Находим клиента по его фамилии и инициалам
	$client = $pDB->get($sql, true, false);	
	if($client) show_rent($client, $app_id);
	else echo '<div class="text-danger pb-2">Клиент с фамилией и инициалами <strong>'.$t_inputFIO.'</strong> тоже не найден. Уточните в прокате номер телефона под которым вы регистрировались.</div>';
}


else{
	
	/* Определяем открыт или закрыт прокат */
	$sql_r = 'SELECT * FROM `rental_org_open_hours` WHERE `id_rental_org` = '.$app_id;		// Выборка текущего статуса проката (открыт/закрыт)
	$rental_org = $pDB->get($sql_r, true, false);
	$current_status = $rental_org[current_status];
	
	if($rental_org[current_status] == 1) {
		$txt_open_close = 'Прокат открыт';
		$style_button_open_close = 'btn-success';
	}
	else {
		$txt_open_close = 'Прокат закрыт';
		$style_button_open_close = 'btn-danger';
	}
?>	
	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/jquery.maskedinput.min.js"></script>
	
	<script type="text/javascript">
   jQuery(function($){
   $("#inputTel").mask("+7 (999) 999-99-99");
   });
	</script>
	
	<div class="row">	
		<div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-3 mx-auto">
			<form method="post">
				<input type="tel" name="inputTel" id="inputTel" class="form-control" aria-describedby="TelHelpBlock" value="<?=$valueTel?>">
				<small id="TelHelpBlock" class="form-text text-muted pb-1">
			  	Введите номер <strong>телефона</strong> по которому вы регистрировались в базе проката
				</small>
				<button type="submit" class="btn btn-primary" id="submit">Поиск</button>
			</form>
			<div class="pt-5">
				<button type="button" class="btn <?=$style_button_open_close ?>" disabled><?=$txt_open_close ?></button>
			</div>
			<div>Свободных велосипедов: <strong><?=(count_free_bike($app_id)-1) ?></strong></div>
		</div>
	</div>

<?
}
/* Функция вывода данных проката */
function show_rent($client, $app_id){
	/* Если клиента успешно нашли в базе по телефону */
	
	global $pDB;
	
	$sql = 'SELECT * FROM `orders` WHERE `status` = \'ACTIVE\' AND `id_rental_org` = '.$app_id.' AND customer_id='.$client['id_rent'].' ORDER BY id DESC LIMIT 0,1';		// Находим активный заказ по ID клиента
	$order = $pDB->get($sql, true, false);

	if(!$order){
		/* Если активный заказ не нашли, то берем последний заказ */
		$sql = 'SELECT * FROM `orders` WHERE `id_rental_org` = '.$app_id.' AND customer_id='.$client['id_rent'].' ORDER BY id DESC LIMIT 0,1';
		$order = $pDB->get($sql, true, false);	
	}
	
	if($order[id]){
	
		//echo '<p><strong>Сумма: '.$order[bill].' руб.</strong></p>';
		if($order[bill_no_sale] != $order[bill]) $txt_bill_nosale = '<BR><small class="text-muted">Без учета скидки ('.$client[sale].'%): '.$order[bill_no_sale].' руб.</small>';
		if($order[status] == 'ACTIVE') $txt_order_status = '<span class="text-success">активен</span>';
		else if($order[status] == 'END') $txt_order_status = 'завершен';

		if(date("Y-m-d") == date("Y-m-d",strtotime($order[start_time]))){		// Если сегодняшний прокат, то не выводим дату
			$start_time	= date("H:i",strtotime($order[start_time]));
			$end_time	= date("H:i",strtotime($order[end_time]));
		}
		else {
			$start_time = date("H:i d-m-Y",strtotime($order[start_time]));
			$end_time = date("H:i d-m-Y",strtotime($order[end_time]));
		}
		if($order[end_time]) $txt_end_time = '<div>Время завершения: '.$end_time.'</div>';
		
		$from_time = new DateTime($order[start_time]);
		$to_time = new DateTime($order[end_time]);
		$interval = $from_time->diff($to_time);
		$time_diff = $interval->format('%hч %iмин');
		
		
		$order_products = json_decode($order[products]);
		for($i=0; $i < count($order_products); ++$i){				// Перебираем все заказы
			$sql_p = 'SELECT * FROM `products` WHERE `id_rent` = '.$order_products[$i].' AND `id_rental_org` = '.$app_id;		// Выборка названия товара
			$products = $pDB->get($sql_p, true, false);
			$output_prod .= '<small>'.$products[name].'</small><BR>';
		}
		

		echo '
		<div class="row">
			<div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-3 mx-auto">
				<p><strong>Сумма: '.$order[bill].' руб.</strong>
					'.$txt_bill_nosale.'</p>
				<div>Статус: '.$txt_order_status.'</div>
				<div>Длительность: '.$time_diff.'</div>
				<div>Время начала проката: '.$start_time.'</div>
				'.$txt_end_time.'
				<div class="pt-3">Список велосипедов:</div>
				'.$output_prod.'
			</div>
		</div>	
		';

		if($order[status] == 'ACTIVE'){
			echo'
			<script type="text/javascript">
				function timedRefresh(timeoutPeriod) {
					setTimeout("location.reload(true);",timeoutPeriod);
				}
				window.onload =  function() {
					client_id = '.$client[id].';
					//console.log(client_id);
					try {
						js_webviews.send(client_id);
					} catch (err) {}
					timedRefresh(5000);
				}
			</script>	
			';
		}
		else{
			echo '<form method="post">
							<div class="col-12 col-sm-9 col-md-7 col-lg-5 col-xl-4 mx-auto pt-2"><button type="submit" class="btn btn-primary">Возврат</button></div>
						</form>';
		}
	}
	else echo '<div class="text-danger pb-2">Заказ не найден</div>';
}



/* Функция подключения БД */
function rent_connect_DB(){
	include_once('lib.db.php');

	$pDB = new Pdo_Db();

	$pDB->connect();
	if (!$pDB->isConnected()){
		echo "Ошибка подключения к БД";
		die();
	}
	return $pDB;
}

/* Функция подсчета кол-ва свободных велосипедов */
function count_free_bike($app_id){
	global $pDB;
		
	$not_in_rental = '0,';
		
	$sql = 'SELECT * FROM `orders` WHERE `status` = \'ACTIVE\' AND `id_rental_org` = '.$app_id;		// Перебираем все активные заказы

	$o = $pDB->get($sql, false, true);	
	foreach ($o as $orders) { 
		$orders_products = json_decode($orders[products]);
		for($i=0; $i < count($orders_products); ++$i){				// Перебираем все заказы
			$output_count_busy_prod++;			// Кол-во занятых товаров
			//$sql_p = 'SELECT * FROM `products` WHERE `id_rent` = '.$orders_products[$i].' AND `id_rental_org` = '.$app_id;		// Выборка названия товара
			//$products = $pDB->get($sql_p, true, false);
			//$output_busy_prod .= $products[name].'<BR>';
			$not_in_rental .= $orders_products[$i].',';
		}
	}

	$sql = 'SELECT * FROM `products` WHERE `id_rent` NOT IN ('.trim($not_in_rental,',').') AND `active` = 1 AND `id_rental_org` = '.$app_id.' ORDER BY `name`';		// Перебираем все товары кроме занятых
	$p = $pDB->get($sql, false, true);	
	foreach ($p as $products) { 
		//$output_free_prod .= $products[name].'<BR>';
		$output_count_free_prod++;
	}
	
	return $output_count_free_prod;
}

?>		

	</div>
</body>
</html>