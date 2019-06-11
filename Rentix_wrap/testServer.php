<html>
<head>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>

      var send = function () {

        $.ajax({
          type: "POST",
          url: "./libs/details.php",
          data: {cmds: [{cmd:'getOrders'},{cmd:'getSubOrders'}]}
        }).done(function (result) {
          $("#msg").append('<div>' + result + '</div>');
        });
      };

      function getdetails() {
        $("#msg").append('<div>' + 'Начинаю выполнять ajax запросы...' + '</div>');
        $("#msg").append('<div>' + "data: {cmds: [{cmd:'getOrders'},{cmd:'getSubOrders'}]}" + '</div>');
        $("#msg").append('<div>' + "Частота = 3 секунды" + '</div>');

        setInterval(function () {
          send();
        }, 3000);
      }
    </script>
</head>
<body>
<p>Нажмите, чтобы начать отправлять запросы на тестовый сервер</p>
<button onClick = "getdetails()">Начать</button>

<div id="msg"></div>
</body>
</html>