<style>
    /* Заголовок и Карточки */
    h1 { font-size: 48px; font-weight: normal; margin: 60px 0 50px 0; text-align: center; }
    
    .cards-container { display: flex; gap: 40px; justify-content: center; margin-bottom: 80px; }
    
    .card {
        width: 300px; height: 200px; border-radius: 35px; display: flex; 
        flex-direction: column; align-items: center; justify-content: center; background-color: #fff;
    }
    .card-blue { border: 2px solid #4F90FF; }
    .card-red { border: 2px solid #FF6B6B; }
    .card-yellow { border: 2px solid #FFD93D; }

    .card-number { font-size: 42px; font-weight: bold; margin-bottom: 10px; }
    .card-blue .card-number { color: #4F90FF; }
    .card-red .card-number { color: #FF6B6B; }
    .card-yellow .card-number { color: #FFD93D; }
    .card-label { font-size: 22px; color: #888; }

    /* Секции с таблицами */
    .section-container { width: 850px; margin: 0 auto 80px auto; display: flex; flex-direction: column; }
    
    .action-button {
        width: 380px; height: 55px; background-color: #5B95FF; color: white;
        border: none; border-radius: 10px; font-size: 22px; margin-bottom: 20px;
        cursor: pointer; display: flex; align-items: center; justify-content: center; text-decoration: none;
    }

    .table-box {
        width: 100%; border: 2px solid #4F90FF; border-radius: 35px;
        padding: 30px 40px; box-sizing: border-box;
    }

    .table-title { font-size: 20px; margin-bottom: 25px; text-align: left; font-weight: bold; }

    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th { text-align: center; padding-bottom: 15px; border-bottom: 1px solid #000; font-weight: normal; }
    td { text-align: center; padding: 15px 0; border-bottom: 1px solid #ddd; }
    tr:last-child td { border-bottom: none; }
</style>

<h1>Панель управления складом</h1>

<div class="cards-container">
    <div class="card card-blue">
        <div class="card-number">1000</div>
        <div class="card-label">Товаров на складе</div>
    </div>
    <div class="card card-red">
        <div class="card-number">16</div>
        <div class="card-label">Ниже мин. остатка</div>
    </div>
    <div class="card card-yellow">
        <div class="card-number">27</div>
        <div class="card-label">Списаний за месяц</div>
    </div>
</div>

<div class="section-container">
    <?php if (app()->auth->user()->role === 'admin'): ?>
        <a href="#" class="action-button">Заказать товар</a>
    <?php endif; ?>
    <div class="table-box">
        <div class="table-title">Товары, требующие заказа</div>
        <table>
            <thead>
                <tr><th>Наименование</th><th>Артикул</th><th>Ед. изм.</th><th>Остаток</th><th>Мин. норма</th></tr>
            </thead>
            <tbody>
                <tr><td>Бумага А4</td><td>4515-564</td><td>Пачек</td><td>3</td><td>10</td></tr>
                <tr><td>Скрепки</td><td>6547-256</td><td>Коробка</td><td>60</td><td>120</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="section-container">
    <?php if (app()->auth->user()->role === 'admin'): ?>
        <a href="#" class="action-button">Добавить поставку</a>
    <?php endif; ?>
    <div class="table-box">
        <div class="table-title">Последние поставки</div>
        <table>
            <thead>
                <tr><th>Наименование</th><th>Поставщик</th><th>Количество</th><th>Цена за ед.</th><th>Дата поставки</th></tr>
            </thead>
            <tbody>
                <tr><td>Бумага А4</td><td>Фуфлкорпрэйшен</td><td>4 пачки</td><td>320 р</td><td>13.04.2026</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="section-container">
    <?php if (app()->auth->user()->role === 'admin'): ?>
        <a href="#" class="action-button">Списать товар</a>
    <?php endif; ?>
    <div class="table-box">
        <div class="table-title">Последние списания</div>
        <table>
            <thead>
                <tr><th>Наименование</th><th>Количество</th><th>Сотрудник</th><th>Подразделение</th><th>Дата выдачи</th></tr>
            </thead>
            <tbody>
                <tr><td>Бумага А4</td><td>4 пачки</td><td>Васильков А. В.</td><td>Бухгалтерия</td><td>11.04.2026</td></tr>
            </tbody>
        </table>
    </div>
</div>