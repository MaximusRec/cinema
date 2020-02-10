<div class="center">
    <?php if (!empty($new)): ?>
        <h1>Создать новый фильма</h1>
    <?php elseif (!empty($edit)): ?>
        <h1>Редактирование фильма</h1>
    <?php endif; ?>
    <?php if (!empty($message)): ?>
        <div class="fail"><?= $message ?></div>
        <hr>
    <?php endif; ?>

</div>

<form id="form-film" action="<?= $action ?>" method="post" enctype="multipart/form-data" >
    <?php if (!empty($film['a_id'])): ?>
        <p>id: <?= $film['a_id'] ?></p>
        <input type="hidden" name="a_id"  value="<?= $film['a_id'] ?>" >
    <?php endif; ?>

    <p>Название фильма<br>
        <input type="text" name="name_film" id="id_name_film" size="50" value="<?= $film['name_film'] ?>" placeholder="Введите название фильма" autofocus required></p>

    <div class="coverholder">
    <p>Постер<br>
        <?php if (!empty($edit)): ?><img alt="<? echo $film['name_film']; ?>" src="<?= $film['poster']; ?>" ><?php endif; ?>
        <input type="hidden" name="poster" id="id_poster" size="50" value="<?= $poster ?>" ><br>
        <input type="file" name="poster_file"></p>
    </div>

    <p>Описание<br>
        <textarea type="text" rows="5" cols="100" name="description" id="id_description" ><?php if (!empty($edit)) {echo $film['description'];} ?></textarea></p>

    <p>Начало показа<br>
        <input type="text" name="date_start" id="id_date_start" size="14" pattern="[0-9\-]{10}" value="<?php if (!empty($new)) { echo date('Y-m-d' ,time()); } else { echo $film['date_start']; } ?>" placeholder="2000-01-10" required></p>

    <p>Окончание показа<br>
        <input type="text" name="date_end" id="id_date_end" size="14" pattern="[0-9\-]{10}" value="<?php if (!empty($new)) { echo date('Y-m-d' ,time() + (24*60*60)); } else { echo $film['date_end']; } ?>" placeholder="2000-01-10" required></p>

    <?php if (!empty($film['a_id'])): ?>
        <p>Выберите время сеансов<br>
        <?php foreach ($seances as $key => $value): ?>
            <label><input type="checkbox" name="film_seances[]" value="<?= $key ?>" <?php if (in_array($key, $film_seances) ) echo "checked=checked"; ?> class="checkbox-style" ><?= $value . " " ?></label>
            <? if (($key % 12) == 0 ) { echo "<br>"; } ?>
        <?php endforeach; ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($edit)): ?>
        <p>Опубликовано<br><input type="text" name="date_added" id="id_date_added" size="14" pattern="[0-9\-: ]{20}" value ="<?= $film['date_added']; ?>" placeholder="2000-01-10 10:12:50" readonly></p>
    <?php endif; ?>

    <?php if (!empty($film['a_id'])): ?>
        <p>Модифицирован<br>
            <input type="text" name="date_modication" id="id_date_modication" size="14" value ="<?php if (!empty($edit)) {echo $film['date_modication'];} ?>" readonly></p>
    <?php endif; ?>

    <div class="center">
    <?php if (!empty($new)): ?>
        <input type="submit" name="create" value="Сохранить новый">
    <?php elseif (!empty($edit)): ?>
        <input type="submit" name="save" value="Сохранить старый">
    <?php endif; ?>
    </div>
</form>

