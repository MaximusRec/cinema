<?php if (!empty($result_del) AND ($result_del === false )): ?>
    <div class="fail"><?= $message ?></div>
<?php endif; ?>

<form id="form-tiket" action="<?= $action ?>" method="post">
    <?php if (!empty($films)): ?>
        <h2 class="films">Администрирование. Список фильмов.</h2>
            <input type="submit" name="new" value="Создать новый фильм">
            <input type="submit" name="del" value="Удалить выбранные фильмы">
        <hr>
    <table>
        <tr>
            <th></th>
            <th>id</th>
            <th>Название фильма</th>
            <th>Начало показа</th>
            <th>Окончание показа</th>
            <th>Опубликовано</th>
        </tr>
            <?php foreach ($films as $valueFilm): ?>
                     <tr>
                         <td><input type="checkbox" name="films[]" value="<?= $valueFilm['a_id']; ?>" class="checkbox-style" ></td>
                         <td><?= $valueFilm['a_id']; ?></td>
                         <td class="left"><a href="/admin/editfilm?id=<?= $valueFilm['a_id']; ?>" title="Редактировать"><?= $valueFilm['name_film']; ?></a></td>
                         <td><?= $valueFilm['date_start'] ?></td>
                         <td><?= $valueFilm['date_end'] ?></td>
                         <td><?= $valueFilm['date_added'] ?></td>
                     </tr>
            <?php endforeach; ?>
    </table>
    <?php endif; ?>
</form>
