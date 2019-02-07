<?PHP
$email = "koltykov@gmail.com";
//$email = "IzyXRKcfliVjqJ@dkimvalidator.com";
$subject = "TEST DKIM ".rand(1,100);
$text = "Тест отправки с рентикс ".rand(1,100).' - '.$_SERVER['HTTP_HOST'];

//$headers  = "Content-type: text/html; charset=utf-8 \r\n"; 
$headers .= "From: Анатолий <anatoliy@rentix.biz>\r\n"; 
$headers .= "Reply-To: noreply@rentix.biz\r\n"; 

$mail = mail($email, $subject, $text, $headers, '-fnoreply@'.$_SERVER['HTTP_HOST']);


?>