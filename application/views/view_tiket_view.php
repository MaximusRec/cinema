<form id="form-tiket" action="<?= $action ?>" method="post">
     <?php if (!empty($films)): ?>

        <p>Выберите фильма<br>
            <select size="1" name="id_film" id="id_film">
            <?php foreach ($films as $valueFilm): ?>
                <option value="<?= $valueFilm['a_id']; ?>"><?= $valueFilm['name_film']; ?></option>
            <?php endforeach; ?>
        </select></p>
     <?php endif; ?>

     <hr>
        <div id="date_seanse">
        <p>Выберите дату сеанса<br>
        <select size="1" name="select_date" id="select_date" >
                <?php foreach ($dates as $valueD): ?>
                    <option value="<?= $valueD; ?>"><?= date_format( date_create($valueD), 'd.m.Y'); ?></option>
                <?php endforeach; ?>
            </select></p>
        </div>
        <hr>

        <div id="tikets">
            <?php if (!empty($tiket)): ?>
            <table class="table-tiket">
                <tr>
                    <td>Сеанс</td>
                    <td>Кол-во билетов</td>
                </tr>
                <?php foreach ($tiket as $valueT): ?>
                    <tr>
                        <td>$valueT['time']</td>
                        <td>$valueT['count_tiket']</td>
                    </tr>
                <?php endforeach; ?>
             <table>
             <?php else: ?>
                 <div class="not-tikets-day">Нет купленых билетов на фильм на <?= $date ?> число</div>
            <?php endif; ?>
        </div>
</form>


<script>
    function create_result()
    {
        $.ajax({
            url: '/admin/seanses',
            type: 'post',
            dataType: 'html',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            data: $("#form-tiket").serialize(),
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (html) {
                $("#tikets").html(html);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Функция при ошибочном запросе
                console.error('Ajax request failed', jqXHR, textStatus, errorThrown);
            }
        });
    }

    $('#id_film').on('change', function(){
        $.ajax({    //  получаем список доступных дат для выбранного фильма и модифицир. select с датами
            url: '/admin/datesfilm',
            type: 'post',
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: $("#form-tiket").serialize(),
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (json) {
                var $sel = $("#select_date");
                $sel.empty();

                $(json).each(function() {
                    $sel.append('<option value="' + this.value1 + '">'+ this.value2  +' </option>');
                });
                $sel.change();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // Функция при ошибочном запросе
                console.error('Ajax request failed', jqXHR, textStatus, errorThrown);
            }
        });

        create_result();    //  получаем список купленных билетов и добавляем в блок tikets
    });

    $('#select_date').on('change', function(){
        create_result();    //  получаем список купленных билетов и добавляем в блок tikets
    });
</script>