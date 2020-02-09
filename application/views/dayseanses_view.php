    <?php if (!empty($tiket)): ?>
         <table>
             <tr>
                 <td>Сеанс</td>
                 <td>Кол-во билетов</td>
                 <td>Купленные места</td>
             </tr>
             <?php foreach ($tiket as $valueT): ?>
                 <tr>
                     <td><?= $valueT['time'] ?></td>
                     <td class="b"><?= $valueT['count_tiket'] ?></td>
                     <td class="left"> <span class="b"><?= $valueT['cinema_seats'] ?></span> ( пустых осталось <span class="b"><?= (50 - count(explode(",",$valueT['cinema_seats']))) ?></span> мест)</td>
                 </tr>
             <?php endforeach; ?>
          </table>
    <?php else: ?>
        <div class="not-tikets-day">Нет купленых билетов на фильм на <?= $date ?> число</div>
    <?php endif; ?>
