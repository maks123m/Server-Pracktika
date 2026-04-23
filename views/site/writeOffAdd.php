<style>
    .wrapper { display: flex; justify-content: center; align-items: center; height: 80vh; }
    .container {
        width: 600px; height: 450px; background-color: #ffffff;
        border: 2px solid #4F90FF; border-radius: 40px;
        display: flex; flex-direction: column; align-items: center;
        justify-content: center; box-sizing: border-box; padding: 20px;
    }
    h2 { font-size: 32px; font-weight: normal; margin-bottom: 35px; color: #000; }
    .input-field {
        width: 380px; height: 45px; background-color: #ebebeb;
        border: 2px solid #4F90FF; border-radius: 10px;
        margin-bottom: 25px; padding: 0 15px; font-size: 22px; color: #000; outline: none;
    }
    .btn-submit {
        width: 230px; height: 65px; background-color: #4F90FF;
        border: none; border-radius: 10px; color: white;
        font-size: 22px; cursor: pointer; margin-top: 15px;
    }
</style>

<div class="wrapper">
    <form class="container" method="POST" style="height: auto; padding: 40px;">
        <h2>Списать товар</h2>
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <select name="product_id" class="input-field" required>
            <option value="" disabled selected>Выберите товар</option>
            <?php foreach ($products as $product): ?>
                <option value="<?= $product->id ?>">
                    <?= $product->name ?> (Остаток: <?= $product->quantity ?> <?= $product->unit ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <input type="number" name="quantity" class="input-field" placeholder="Количество" required min="1">
        
        <input type="text" name="employee" class="input-field" placeholder="ФИО сотрудника" required>

        <select name="department" class="input-field" required>
            <option value="" disabled selected>Выберите департамент</option>
            <?php foreach ($subdivisions as $sub): ?>
                <option value="<?= $sub->name ?>"><?= $sub->name ?></option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" class="btn-submit">Подтвердить выдачу</button>
    </form>
</div>