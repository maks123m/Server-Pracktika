<style>
    h1 { font-size: 48px; font-weight: normal; margin: 60px 0 40px 0; text-align: center; }
    
    .add-button {
        width: 380px; height: 55px; background-color: #5B95FF; color: white;
        border: none; border-radius: 10px; font-size: 22px; margin: 0 auto 50px auto;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        text-decoration: none;
    }

    .table-container {
        width: 1000px; border: 2px solid #4F90FF; border-radius: 45px;
        padding: 40px 50px; box-sizing: border-box; margin: 0 auto 50px auto;
    }

    table { width: 100%; border-collapse: collapse; }
    th { font-size: 20px; font-weight: normal; padding-bottom: 20px; border-bottom: 1px solid #999; text-align: center; }
    td { font-size: 18px; padding: 20px 0; text-align: center; border-bottom: 1px solid #ccc; }
    tr:last-child td { border-bottom: none; }

    .action-delete { color: #FF6B6B; text-decoration: none; }
</style>

<h1>Список всех подразделений</h1>

<a href="<?= app()->route->getUrl('/subdivision/add') ?>" class="add-button">+ Добавить подразделение</a>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">№</th>
                <th style="width: 50%;">Подразделение</th>
                <th style="width: 30%;">Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subdivisions as $subdivision): ?>
                <tr>
                    <td><?= $subdivision->id ?></td>
                    <td><?= $subdivision->name ?></td>
                    <td>
                        <a href="<?= app()->route->getUrl('/subdivision/delete?id=' . $subdivision->id) ?>" class="action-delete" 
                        onclick="return confirm('Вы уверены, что хотите удалить?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>