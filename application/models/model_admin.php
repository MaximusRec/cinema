<?php

class Model_Admin
{
    var $pdo;

    public function __construct()
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/db/" . "pdoconnect.php";
        $this->pdo= $pdo;   //  инициализируем БД
    }

    /**
     * Получаем список всех фильмов.
     * Пагинацию не делал, нет в ТЗ, сделаю лимит 50, т.к. в кинотеатре одновременно больше премьер не ожидается.
     *
     * @return bool|null
     */
    public function getFilms()
    {
        $sql = "SELECT `a_id`, `name_film`, `date_start`, `date_end`, `date_added` FROM `films` f ORDER BY `date_added` ASC LIMIT 50";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute();
            $data = $queryes->fetchAll();

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
           return false;
        }

        //  Модифицирууем массив чтоб не делать это в view для красооты вывода
        if (!empty($data)) {
            foreach ( $data as &$value){
                $value['date_start'] = date_format( date_create($value['date_start']), 'd.m.Y');
                $value['date_end'] = date_format( date_create($value['date_end']), 'd.m.Y');
                $value['date_added'] = date_format( date_create($value['date_added']), 'd.m.Y H:i');
            }
        }

        return $data;
    }

    /**
     * Получаем по id фильма все данные по фильму
     *
     * @param $id_film
     * @return bool
     */
    public function getFilm($id_film)
    {
        $sql = "SELECT `a_id`,`name_film`,`poster`,`description`,`date_start`,`date_end`,`date_added`,`date_modication` , GROUP_CONCAT(s2t.`id_seances`) as `all_seances`
                FROM `films` f 
                    LEFT JOIN `seances_to_film` s2t ON s2t.`id_film` = f.`a_id`
                WHERE `a_id` = :id_film LIMIT 1";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute([ ':id_film' => $id_film]);
            $data = $queryes->fetchAll();

        } catch (PDOException $e) {	$data = false;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }

    /**
     * Получаем все возможные сеансы
     *
     * @return bool
     */
    public function getAllSeance()
    {
        $sql = "SELECT `id_seance`, `time` FROM `seances` ORDER BY `a_order`";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute();
            $data = $queryes->fetchAll(PDO::FETCH_KEY_PAIR);

        } catch (PDOException $e) {	$data = false;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }


    /**
     * Сохраняем изменения параметров фильма
     *
     * @param $data
     * @return bool|null
     */
    public function editFilm($data)
    {
        $sql = "UPDATE `films` SET `name_film` = :name_film, `poster` = :poster, `description` =  :description, `date_start` = :date_start, `date_end` = :date_end WHERE `a_id` = :a_id LIMIT 1";

        try {
            $queryes = $this->pdo->prepare($sql);
            $data = $queryes->execute( [
                ':a_id' => $data['a_id'],
                ':name_film' => $data['name_film'],
                ':poster' => $data['poster'],
                ':description' => $data['description'],
                ':date_start' => $data['date_start'],
                ':date_end' => $data['date_end'],
            ] );

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }

    /**
     *  Создаем фильма
     *
     * @param $data
     * @return bool|null
     */
    public function createFilm($data)
    {
        $sql = "INSERT INTO `films` (`name_film`,`poster`,`description`,`date_start`,`date_end`) VALUES (:name_film, :poster, :description, :date_start, :date_end)";

        try {
            $queryes = $this->pdo->prepare($sql);
            $result = $queryes->execute([
                ':name_film' => $data['name_film'],
                ':poster' => $data['poster'],
                ':description' => $data['description'],
                ':date_start' => $data['date_start'],
                ':date_end' => $data['date_end'],
            ]);

            if ($result) $data = $this->pdo->lastInsertId();

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }

    /**
     * Сохраняем сеансы для заданного фильма. Предварительно удаляв для этого фильма все записи.
     *
     * @param $id_film
     * @param $film_seances
     * @return array|bool|null
     */
    public function saveSeances($id_film, $film_seances)
    {
        if (!empty($id_film) AND !empty($film_seances)) {
            //  удаляем сеансы для этого фильма
            $sql = "DELETE FROM `seances_to_film` WHERE `id_film` = :id_film";

            try {
                $queryes = $this->pdo->prepare($sql);
                $result1 = $queryes->execute([':id_film' => $id_film]);
            } catch (PDOException $e) {
                $result1 = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                return false;
            }

            //  записываем сеансы
            foreach ($film_seances as $seance) {
                $sql = "INSERT INTO `seances_to_film` (`id_film`, `id_seances`) VALUES (:id_film, :id_seances)";

                try {
                    $queryes = $this->pdo->prepare($sql);
                    $result2 = $queryes->execute([
                            ':id_film' => $id_film,
                            ':id_seances' => $seance,
                        ]);

                    if ($result2) $results[] = $this->pdo->lastInsertId();

                } catch (PDOException $e) {
                    $results = null;
                    echo 'Подключение не удалось: ' . $e->getMessage();
                    return false;
                }
            }

            return $results;
        } else return false;
    }



    /**
     * Удаляем список фильмов
     *
     * @param $listFilms
     * @return bool|null
     */
    public function delFilms($listFilms)
    {
        $in  = str_repeat('?,', count($listFilms) - 1) . '?';
        $sql = "DELETE FROM `films` WHERE `a_id` IN ($in)";

        try {
            $queryes = $this->pdo->prepare($sql);
            $data = $queryes->execute( $listFilms );

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }

    /**
     * Получаем список купленных билетов с привязкой к сеансам, также данные по номерам мест
     *
     * @return bool|null
     */
    public function getTiketByFilm($id_film, $day)
    {
        $sql = "SELECT `seance`, s.time, COUNT(`a_id`) as `count_tiket` , GROUP_CONCAT(t.`cinema_seat` ORDER BY t.`cinema_seat`) as `cinema_seats`
                    FROM `tikets` t
                      LEFT JOIN  `seances` s ON t.`seance` = s.`id_seance`
                    WHERE `date_cinema` = :date AND `id_film` = :id_film
                    GROUP BY `seance`";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute([ ':id_film' => $id_film, ':date' => $day ] );
            $data = $queryes->fetchAll();

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }
        return $data;
    }

}