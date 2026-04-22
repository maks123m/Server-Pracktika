<style>
    /* Твои стили без изменений */
    .auth-container {
        width: 500px;
        height: 400px;
        background-color: #ffffff;
        border: 2px solid #4F90FF;
        border-radius: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 40px;
        box-sizing: border-box;
        margin: 50px auto; /* Центрируем форму */
    }

    h2 {
        font-size: 32px;
        font-weight: normal;
        margin-bottom: 25px;
        margin-top: 0;
    }

    .error-msg {
        color: #FF6B6B;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .input-field {
        width: 320px;
        height: 40px;
        background-color: #ebebeb;
        border: 2px solid #4F90FF;
        border-radius: 10px;
        margin-bottom: 25px;
        padding: 0 15px;
        font-size: 20px;
        color: #333;
        outline: none;
    }

    .btn-login {
        width: 190px;
        height: 65px;
        background-color: #4F90FF;
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 22px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .register-link {
        font-size: 16px;
        color: black;
        text-decoration: none;
    }
</style>

<div class="auth-container">
    <h2>Авторизация</h2>

    <?php if (isset($message)): ?>
        <div class="error-msg"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" style="display: flex; flex-direction: column; align-items: center;">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input type="text" name="login" class="input-field" placeholder="Логин" required>
        <input type="password" name="password" class="input-field" placeholder="Пароль" required>
        <button type="submit" class="btn-login">Войти</button>
    </form>
    
    <a href="<?= app()->route->getUrl('/signup') ?>" class="register-link">Зарегистрироваться</a>
</div>