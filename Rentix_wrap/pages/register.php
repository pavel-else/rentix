<?php
    //Подключение шапки
    $_SESSION["page_name"] = "register";
    require_once("../templates/header.php");
?>

<?php 
    //Проверяем, если пользователь не авторизован, то выводим форму регистрации, 
    //иначе выводим сообщение о том, что он уже зарегистрирован
    if(!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
?>
    <div id="form_register" class="form-register">
        <h2>Форма регистрации</h2>
        <form action="../controllers/register.php" method="post" name="form_register" class="auth-form">
            <!-- Блок для вывода сообщений -->
            <div class="block_for_messages">
                <?php

                    //Если в сессии существуют сообщения об ошибках, то выводим их
                    if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
                        echo $_SESSION["error_messages"];

                        //Уничтожаем чтобы не выводились заново при обновлении страницы
                        unset($_SESSION["error_messages"]);
                    }

                    //Если в сессии существуют радостные сообщения, то выводим их
                    if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
                        echo $_SESSION["success_messages"];
                        
                        //Уничтожаем чтобы не выводились заново при обновлении страницы
                        unset($_SESSION["success_messages"]);
                    }
                ?>
            </div>
            
            <div class="form-group">
                <label for="reg_first_name">Имя</label>
                <input class="form-control" name="first_name" id="reg_first_name" required>
            </div>
            <div class="form-group">
                <label for="reg_last_name">Фамилия</label>
                <input class="form-control" name="last_name" id="reg_last_name" required>
            </div>
            <div class="form-group">
                <label for="reg_email">Email</label>
                <input type="email" class="form-control" name="email" id="reg_email" required>
                <small id="valid_email_message" class="form-text text-error mesage_error"></small>
            </div>
            <div class="form-group">
                <label for="reg_password">Пароль</label>
                <input type="password" class="form-control" name="password" id="reg_password" required placeholder="минимум 6 символов">
                <small id="valid_password_message" class="form-text text-error mesage_error"></small>
            </div>
            <div class="form-group form-auth__captcha">
                <label for="reg_captcha">Введите код с картинки</label>
                <div class="auth-captcha__wrap">
                    <img class="auth-captcha__img" src="../controllers/captcha.php" alt="Капча">
                    <input class="form-control" name="captcha" id="reg_captcha" required placeholder="Проверочный код" autocomplete="off">
                </div>
            </div>
            <input type="submit" class="btn btn-primary auth-submit" name="btn_submit_register">
        </form>
    </div>
<?php 
    } else {
?>
    <div id="authorized">
        <h2>Вы уже зарегистрированы</h2>
    </div>

<?php
    }
    
    //Подключение подвала
    require_once("../templates/footer.php");
?>