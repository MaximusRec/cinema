<?php if (!empty($film)): ?>
     <form id="form-tiket" action="<?= $action ?>" method="post">
        <input type="hidden" name="a_id"  value="<?= $film['a_id'] ?>" >
        <input type="hidden" name="name_film"  value="<?= $film['name_film'] ?>" >

        <div class="items" id="hisxne-ptic">
            <div class="coverholder">
                 <img alt="<?= $film['name_film']; ?>" src="<?= $film['poster']; ?>" >
            </div>
             <div class="text">
                 <h3><?= $film['name_film']; ?></h3>
                 <div class="justify"><?= $film['description'] ?></div>
                 <p>Опубликовано: <?= date_format( date_create($film['date_added']), 'd.m.Y H:i'); ?></p>

                 <?php if (!empty($film)): ?>
                 <div id="date_seanse">
                     <p>Выберите дату сеанса<br>
                         <select size="1" name="select_date" id="id_select_date" >
                             <?php foreach ($list_dates as $valueD): ?>
                                 <option value="<?= $valueD; ?>"><?= date_format( date_create($valueD), 'd.m.Y'); ?></option>
                             <?php endforeach; ?>
                         </select></p>
                 </div>
                 <?php else: ?>
                    Нет дней показа для этого фильма
                 <?php endif; ?>


                 <?php if (!empty($film_seances)): ?>
                 <div id="seanse">
                     <p>Выберите сеанс<br>
                         <select size="1" name="select_seance" id="id_select_seance" >
                             <option value="0">Выберите сеанс</option>
                             <?php foreach ($film_seances as $key => $valueS): ?>
                                 <option value="<?= $key ?>"><?= $valueS ?></option>
                             <?php endforeach; ?>
                         </select></p>
                 </div>
                 <?php else: ?>
                    Нет сеансов для этого фильма
                 <?php endif; ?>
             </div>
         </div>

         <hr>

         <div class="center" id="cinema_seats">
         </div>
         <div class="center">
                 <input type="submit" name="pay_tiket" id="id_pay_tiket" value="Купить билет"  disabled >
         </div>
    </form>
<?php endif; ?>


<script>
    function show_cinema()
    {
        $.ajax({
            url: '/main/view_cinema_ceanse/',
            type: 'post',
            dataType: 'html',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: $("#form-tiket").serialize(),
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (html) {
                $("#cinema_seats").html(html);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Функция при ошибочном запросе
                console.error('Ajax request failed', jqXHR, textStatus, errorThrown);
            }
        });
        $("#id_pay_tiket").attr("disabled", false);
    }

    $('#id_select_date').on('change', function(){
        show_cinema();
    });

    $('#id_select_seance').on('change', function(){
        show_cinema();
    });
</script>