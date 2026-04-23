<style>
    .add-form-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
        margin: 0;
    }

    .container-form {
        width: 600px;
        height: 400px;
        background-color: #ffffff;
        border: 2px solid #4F90FF;
        border-radius: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    h2 {
        font-size: 32px;
        font-weight: normal;
        margin-bottom: 40px;
        margin-top: 0;
    }

    .input-field {
        width: 380px;
        height: 45px;
        background-color: #ebebeb;
        border: 2px solid #4F90FF;
        border-radius: 10px;
        margin-bottom: 45px;
        padding: 0 15px;
        font-size: 22px;
        color: #000;
        outline: none;
    }

    .btn-add {
        width: 220px;
        height: 70px;
        background-color: #4F90FF;
        border: none;
        border-radius: 10px;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }
    .container-form { height: auto; padding: 40px; }
    select.input-field { appearance: none; background-color: #ebebeb; cursor: pointer; }
</style>

<div class="add-form-wrapper">
    <form class="container-form" method="POST">
        <h2>Новый сотрудник</h2>
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <input type="text" name="name" class="input-field" placeholder="ФИО" required>
        <input type="text" name="login" class="input-field" placeholder="Логин" required>
        <input type="password" name="password" class="input-field" placeholder="Пароль" required>
        
    <select name="role" class="input-field" required>
        <option value="" disabled selected>Выберите роль</option>
        <option value="admin">Администратор</option>
        <option value="storekeeper">Кладовщик</option> 
    </select>

        <select name="subdivision_id" class="input-field" required>
            <option value="" disabled selected>Подразделение</option>
            <?php foreach ($subdivisions as $sub): ?>
                <option value="<?= $sub->id ?>"><?= $sub->name ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn-add">Добавить</button>
    </form>
</div>