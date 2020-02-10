<h3 class="center">Выберите место *</h3>
<?php $j=1; echo "ряд <span class='b'>{$j}</span> |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if (!empty($placeCinema)): ?>
    <?php foreach ($placeCinema as $key => $value): ?>
        <label><input type="checkbox"  <?php if ($value == 1 ) echo 'name="cinema_seats[]"'; ?> value="<?= $key ?>" <?php if ($value == 0 ) echo "checked=checked onclick='return false;'"; ?> class="checkbox-style" ><?= $key . " " ?></label>
        <? if (($key % 10) == 0 ) { echo "<hr>"; $j++; if ($j <6 ) echo "ряд <span class='b'>{$j}</span> | ";} ?>
    <?php endforeach; ?>
* Места отмеченные галочками уже заняты
<br><br>
<?php else: ?>
    <div class="not-tikets-day">Нет списка мест</div>
<?php endif; ?>