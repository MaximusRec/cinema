    <?php if (!empty($top5)): ?>
        <h2>Самые популярные фильмы</h2>
        <div class="slider">
            <?php foreach ($top5 as $valueTop): ?>
                <div class="item">
                    <div class="items" id="hisxne-ptic">
                        <div class="coverholder">
                            <img alt="<? echo $valueTop['name_film']; ?>" src="<?= $valueTop['poster']; ?>" >
                        </div>
                        <div class="text">
                            <div class="slideText"><a title="<?= $valueTop['name_film']; ?>" href="/main/view?id=<?= $valueTop['id_film']; ?>"><?= $valueTop['name_film']; ?></a></div>
                            <p><?= mb_strimwidth($valueTop['description'], 0, 100, "..."); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <a class="next" onclick="plusSlide()">&#10095;</a>
        </div>
        <div class="slider-dots">
            <?php $i=1; foreach ($top5 as $valueTop): ?>
                <span class="slider-dots_item" onclick="currentSlide(<?= $i++; ?>)"></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>


     <?php if (!empty($films)): ?>
        <hr>
        <h2 class="films">Сейчас на экране</h2>

            <?php foreach ($films as $valueFilm): ?>
                 <div class="items bottom" id="hisxne-ptic">
                     <div class="coverholder">
                         <img style="width: 200px;" alt="<?= $valueFilm['name_film']; ?>" src="<?= $valueFilm['poster']; ?>" >
                     </div>
                     <div class="text">
                         <p><a title="<?= $valueFilm['name_film']; ?>" href="/main/view?id=<?= $valueFilm['a_id']; ?>"><?= $valueFilm['name_film']; ?></a></p>
                         <p><?= mb_strimwidth($valueFilm['description'], 0, 100, "..."); ?></p>
                         <p>Опубликовано: <?= date_format( date_create($valueFilm['date_added']), 'd.m.Y H:i'); ?></p>
                         <button class="button">
                             <a class="link" href="/main/view?id=<?= $valueFilm['a_id']; ?>">Купить билет...</a>
                         </button>
                     </div>
                 </div>
            <?php endforeach; ?>
<hr>
    <?php endif; ?>


    <script src="/js/common.js"></script>