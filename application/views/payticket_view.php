<div class="center">
<?php if (!empty($buyok)): ?>
    <br><br><br><p><span class="success"><?= $message ?></span></p><br><br><br>
        <script>setTimeout("window.location.replace('/main/');", 3000);</script>
<?php else: ?>

    <?php if (!empty($message)): ?>
        <div class="fail"><?= $message ?></div>
        <hr>
    <?php endif; ?>
    </div>

    <p>Вы заказали <span class="b"><?= $count_cinema_seats ?></span> билета(ов) (места № <?= $cinema_seats ?>) на фильм <span class="b"><?= $name_film ?></span>, сеанс в <span class="b"><?= $seance ?></span></p>
    <p>Введите свой телефон и почтовый адрес для завершения оформления билетов.</p>

    <form id="form-film" action="<?= $action ?>" method="post" enctype="multipart/form-data" >

        <input type="hidden" name="id_film"  value="<?= $a_id ?>" >
        <input type="hidden" name="date_cinema"  value="<?= $select_date ?>" >
        <input type="hidden" name="seance"  value="<?= $select_seance ?>" >
        <input type="hidden" name="cinema_seats_json"  value='<?= $cinema_seats_json ?>' >

        <p>Введите свой телефон<br>
            <input type="tel" name="phone" id="id_phone" size="16" value="<?= $phone ?>" pattern="[0-9\-()+ ]{1,20}" placeholder="+38(099)111-2233" autofocus required></p>

        <p>Введите свой email<br>
            <input type="email" name="email" id="id_email" size="16" value="<?php $email; ?>" placeholder="email@domain.com" required></p>

        <div class="center">
            <input type="submit" name="buy" value="Оформить заказ">
        </div>
    </form>
<?php endif; ?>
