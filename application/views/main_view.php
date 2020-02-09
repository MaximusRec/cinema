    <?php if (!empty($top5)): ?>
        <h2>Самые популярные фильмы</h2>
        <ul id="slider">
            <?php foreach ($top5 as $valueTop): ?>
                <li class="slide active">
                <div class="item" id="hisxne-ptic">
                    <div class="coverholder">
                        <img alt="<? echo $valueTop['name_film']; ?>" src="<?= $valueTop['poster']; ?>" >
                    </div>
                    <div class="text">
                        <p><a title="<?= $valueTop['name_film']; ?>" href="/main/view&id=<?= $valueTop['id_film']; ?>"><?= $valueTop['name_film']; ?></a></p>
                        <p><?= mb_strimwidth($valueTop['description'], 0, 100, "..."); ?></p>
                    </div>
                </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="arrows">
            <span class="arrow next" id="next">Вправо</span>
            <span class="arrow prew" id="prew">Влево</span>
        </div>
    <?php endif; ?>

     <?php if (!empty($films)): ?>
        <h2 class="films">Сейчас на экране</h2>

            <?php foreach ($films as $valueFilm): ?>
                 <div class="item" id="hisxne-ptic">
                     <div class="coverholder">
                         <img alt="<?= $valueFilm['name_film']; ?>" src="<?= $valueFilm['poster']; ?>" >
                     </div>
                     <div class="text">
                         <p><a title="<?= $valueFilm['name_film']; ?>" href="/main/view&id=<?= $valueFilm['a_id']; ?>"><?= $valueFilm['name_film']; ?></a></p>
                         <p><? echo mb_strimwidth($valueFilm['description'], 0, 100, "..."); ?></p>
                         <p>Опубликовано: <?= date_format( date_create($valueFilm['date_added']), 'd.m.Y H:i'); ?></p>
                         <button class="button">
                             <a class="link" href="/main/view&id=<?= $valueFilm['a_id']; ?>">Купить билет...</a>
                         </button>
                     </div>
                 </div>
            <?php endforeach; ?>

    <?php endif; ?>

    <script src="/js/common.js"></script>