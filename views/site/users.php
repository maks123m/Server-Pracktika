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
    .separator { color: #000; margin: 0 5px; }
</style>

<h1>Список всех сотрудников</h1>

<a href="<?= app()->route->getUrl('/user/add') ?>" class="add-button">+ Добавить сотрудника</a>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>№</th>
                <th>Фото</th>
                <th>ФИО</th>
                <th>Логин</th>
                <th>Роль</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td>
                    <?php if ($user->image): ?>
                        <img src="<?= $user->image ?>" alt="avatar" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 70px; height: 70px; background: #ccc; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;">No фото</div>
                    <?php endif; ?>
                    </td>
                    <td><?= $user->name ?></td>
                    <td><?= $user->login ?></td>
                    <td><?= $user->role ?></td>
                    <td>
                        <a href="<?= app()->route->getUrl('/user/delete?id=' . $user->id) ?>" 
                           class="action-delete" onclick="return confirm('Удалить?')">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>