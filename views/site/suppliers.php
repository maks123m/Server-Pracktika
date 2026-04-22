<h1>Список поставщиков</h1>
<a href="#" class="add-button">+ Добавить поставщика</a>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Компания</th>
                <th>Контактное лицо</th>
                <th>Телефон</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($suppliers as $s): ?>
                <tr>
                    <td><?= $s->id ?></td>
                    <td><?= $s->name ?></td>
                    <td><?= $s->contact_person ?></td>
                    <td><?= $s->phone ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>