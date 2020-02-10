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
                     <td><?= $valueT['count_tiket'] ?></td>
                     <td><?= $valueT['cinema_seats'] ?></td>
                 </tr>
             <?php endforeach; ?>
          </table>
    <?php else: ?>
        <div class="not-tikets-day">Нет купленых билетов на фильм</div>
    <?php endif; ?>
