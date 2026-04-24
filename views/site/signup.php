<style>

    .auth-container {
        width: 650px;
        min-height: 750px;
        background-color: #ffffff;
        border: 2px solid #4F90FF;
        border-radius: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        padding: 40px 20px;
        margin: 20px auto;
    }

    h2 {
        font-size: 32px;
        font-weight: normal;
        margin-bottom: 30px;
        margin-top: 0;
    }

    .input-field {
        width: 410px;
        height: 45px;
        background-color: #ebebeb;
        border: 2px solid #4F90FF;
        border-radius: 12px;
        margin-bottom: 15px;
        padding: 0 15px;
        font-size: 22px;
        color: #333;
        outline: none;
    }


    .file-label {
        width: 410px;
        font-size: 16px;
        color: #4F90FF;
        margin-bottom: 5px;
        text-align: left;
    }

    .input-file {
        padding-top: 5px;
        font-size: 16px;
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
    
    pre {
        color: red;
        white-space: pre-wrap;
        text-align: center;
    }
</style>

<div class="auth-container">
    <h2>Регистрация</h2>
    <pre><?= $message ?? ''; ?></pre>
    
    <form method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; align-items: center;">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        
        <input type="text" name="name" class="input-field" placeholder="ФИО" required>
        <input type="text" name="login" class="input-field" placeholder="Логин" required>
        <input type="password" name="password" class="input-field" placeholder="Пароль" required>
        
        <select name="role" class="input-field">
            <option value="storekeeper">Кладовщик</option>
            <option value="admin">Администратор</option>
        </select>

        <input type="file" name="image" class="input-field input-file">

        <button type="submit" class="btn-register">Зарегистрироваться</button>
    </form>

    <div class="login-link">
        Уже есть аккаунт? <a href="<?= app()->route->getUrl('/login') ?>">Войти</a>
    </div>
</div>