<style>
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
        <div class="card-number"><?= $totalItems ?? 0 ?></div>
        <div class="card-label">Товаров на складе</div>
    </div>

    <div class="card card-red">
        <div class="card-number"><?= $lowStockCount ?? 0 ?></div>
        <div class="card-label">Ниже мин. остатка</div>
    </div>

    <div class="card card-yellow">
        <div class="card-number"><?= $monthlyWriteOffs ?? 0 ?></div>
        <div class="card-label">Всего списаний</div>
    </div>
</div>

<div class="section-container">
    <?php if (app()->auth->user()->role === 'admin'): ?>
        <a href="<?= app()->route->getUrl('/order/add') ?>" class="action-button">Заказать товар</a>
    <?php endif; ?>
    <div class="table-box">
        <div class="table-title">Товары, требующие заказа</div>
        <table>
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Артикул</th>
                    <th>Ед. изм.</th>
                    <th>Остаток</th>
                    <th>Мин. норма</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($ordersToRequest->isEmpty()): ?>
                    <tr><td colspan="5">Все товары в наличии (норма)</td></tr>
                <?php else: ?>
                    <?php foreach ($ordersToRequest as $product): ?>
                        <tr>
                            <td><?= $product->name ?></td>
                            <td><?= $product->sku ?></td>
                            <td><?= $product->unit ?></td>
                            <td style="color: red; font-weight: bold;"><?= $product->quantity ?></td>
                            <td><?= $product->min_norm ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="section-container">
    <div class="table-box">
        <div class="table-title">Последние поставки</div>
        <table>
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Поставщик</th>
                    <th>Количество</th>
                    <th>Цена за ед.</th>
                    <th>Дата поступления</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentDeliveries)): ?>
                    <tr><td colspan="6">Поставок еще не было</td></tr>
                <?php else: ?>
                    <?php foreach ($recentDeliveries as $delivery): ?>
                        <tr>
                            <td><?= $delivery->name ?></td>
                            <td><?= $delivery->supplier ?></td>
                            <td><?= $delivery->quantity ?> <?= $delivery->unit ?></td>
                            <td><?= $delivery->formatted_price ?></td>
                            <td><?= $delivery->formatted_date ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="section-container">
    <?php if (app()->auth->user()->role === 'admin'): ?>
        <a href="<?= app()->route->getUrl('write-off') ?>" class="action-button">Списать товар</a>
    <?php endif; ?>
    <div class="table-box">
        <div class="table-title">Последние списания</div>
        <table>
            <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Сотрудник</th>
                    <th>Департамент</th>
                    <th>Дата выдачи</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentWriteOffs as $wo): ?>
                    <tr>
                        <td><?= $wo->name ?></td>
                        <td><?= $wo->quantity ?> <?= $wo->unit ?></td>
                        <td><?= $wo->employee ?></td>
                        <td><?= $wo->department ?></td>
                        <td><?= $wo->formatted_date ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>