<?php
    session_start();
    $_SESSION["page_name"] = "auth";
    //Подключение шапки
    require_once("../templates/header.php");
?>

<?php
    //Проверяем, если пользователь не авторизован, то выводим форму авторизации, 
    //иначе выводим сообщение о том, что он уже авторизован
    if (!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {
?>

<div id="form_auth" class="form-auth">
    <h2>Форма авторизации</h2>
    <form action="../controllers/auth.php" method="post" name="form_auth" class="auth-form">
        <!-- Блок для вывода сообщений -->
        <div class="auth_block_messages">
            <p id="valid_email_message" class="form-text text-error mesage_error">
                <?php
                    if(isset($_SESSION["error_messages"]) && !empty($_SESSION["error_messages"])){
                        echo $_SESSION["error_messages"];

                        //Уничтожаем чтобы не появилось заново при обновлении страницы
                        unset($_SESSION["error_messages"]);
                    }

                    if(isset($_SESSION["success_messages"]) && !empty($_SESSION["success_messages"])){
                        echo $_SESSION["success_messages"];
                        
                        //Уничтожаем чтобы не появилось заново при обновлении страницы
                        unset($_SESSION["success_messages"]);
                    }
                ?>
            </p>
        </div>
        
        <div class="form-group">
            <label for="auth_email">Email</label>
            <input type="email" class="form-control" name="email" id="auth_email"required="required">
            <small id="valid_email_message" class="form-text text-error mesage_error"></small>
        </div>
        <div class="form-group">
            <label for="auth_password">Пароль</label>
            <input type="password" class="form-control" name="password" id="auth_password" required="required" placeholder="минимум 6 символов">
        </div>
        <div class="form-group form-auth__captcha">
            <label for="auth_captcha">Введите код с картинки</label>
            <div class="auth-captcha__wrap">
                <img class="auth-captcha__img" src="../controllers/captcha.php" alt="Капча">
                <input class="form-control" name="captcha" id="auth_captcha" required="required" placeholder="Проверочный код" autocomplete="off">
            </div>
        </div>
        <input type="submit" class="btn btn-primary auth-submit" name="btn_submit_auth">
    </form>
</div>
<?php 
    } else {
?>
    <div id="authorized">
        <h2>Вы уже авторизованы</h2>
    </div>
        
<?php
    }
?>

<?php 
    
    //Подключение подвала
    require_once("../templates/footer.php");
?>