<style>
    /* Стили из твоего макета */
    .auth-container {
        width: 650px;
        height: 700px;
        background-color: #ffffff;
        border: 2px solid #4F90FF;
        border-radius: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        padding: 20px;
        margin: 20px auto;
    }

    h2 {
        font-size: 32px;
        font-weight: normal;
        margin-bottom: 40px;
        margin-top: 0;
    }

    .input-field {
        width: 410px;
        height: 45px;
        background-color: #ebebeb;
        border: 2px solid #4F90FF;
        border-radius: 12px;
        margin-bottom: 20px;
        padding: 0 15px;
        font-size: 22px;
        color: #333;
        outline: none;
    }

    .btn-register {
        width: 245px;
        height: 65px;
        background-color: #4F90FF;
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 20px;
        cursor: pointer;
        margin-top: 20px;
        margin-bottom: 15px;
    }

    .login-link {
        font-size: 18px;
        color: black;
        text-decoration: none;
    }
    
    .login-link a {
        color: #4F90FF;
        text-decoration: none;
        font-weight: bold;
    }

    select.input-field {
        height: 50px;
        color: #757575;
    }
</style>

<div class="auth-container">
    <h2>Регистрация</h2>
    <pre><?= $message ?? ''; ?></pre>
    <form method="post" style="display: flex; flex-direction: column; align-items: center;">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input type="text" name="name" class="input-field" placeholder="ФИО" required>
        <input type="text" name="login" class="input-field" placeholder="Логин" required>
        <input type="password" name="password" class="input-field" placeholder="Пароль" required>
        
        <select name="role" class="input-field">
            <option value="storekeeper">Кладовщик</option>
            <option value="admin">Администратор</option>
        </select>

        <button type="submit" class="btn-register">Зарегистрироваться</button>
    </form>

    <div class="login-link">
        Уже есть аккаунт? <a href="<?= app()->route->getUrl('/login') ?>">Войти</a>
    </div>
</div>