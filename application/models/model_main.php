<?php

class model_main
{
    var $pdo;

    public function __construct()
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/db/" . "pdoconnect.php";
        $this->pdo = $pdo;   // инициализируем БД
    }

    /**
     * Получаем список всех фильмов.
     *
     * @return bool|null
     */
    public function getFilms()
    {
        $sql = "SELECT f.`a_id`, f.`name_film`, f.`poster`, f.`description`, f.`date_added`
                FROM `films` f 
                ORDER BY `date_added` DESC 
                LIMIT 50";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute();
            $data = $queryes->fetchAll();

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
           return false;
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
        $sql = "SELECT `a_id`, `name_film`, `poster`, `description`, `date_start`, `date_end`, `date_added` , GROUP_CONCAT(s2f.`id_seances` ORDER BY s2f.`id_seances`) as `film_seances`
                FROM `films` f 
                    LEFT JOIN `seances_to_film` s2f ON f.`a_id` = s2f.`id_film`
                WHERE `a_id` = :id_film 
                LIMIT 1";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute([ ':id_film' => $id_film]);
            $data = $queryes->fetch();

        } catch (PDOException $e) {	$data = false;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }

    /**
     * Получаем все возможные сеансы в кмнотеатре
     *
     * @return bool
     */
    public function getTimeSeance($listSeances)
    {
        $in  = str_repeat('?,', count($listSeances) - 1) . '?';
        $sql = "SELECT `id_seance`, `time` FROM `seances` WHERE `id_seance` IN ({$in}) ORDER BY `a_order`";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute( $listSeances );
            $data = $queryes->fetchAll(PDO::FETCH_KEY_PAIR);

        } catch (PDOException $e) {	$data = false;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $data;
    }

    /**
     * Получаем купленые билеты на выбранный фильм, дату, сеанс
     *
     * @param $id_film
     * @param $date
     * @param $seance
     * @return array|bool|null
     */
    public function getFilmBuyTicket($id_film, $date, $seance)
    {
        $sql = "SELECT GROUP_CONCAT(`cinema_seat`) as `cinema_seat` FROM `tikets` WHERE `id_film` = :id_film AND `date_cinema` = :date AND `seance` = :seance";

        try {
            $queryes = $this->pdo->prepare($sql);
            $queryes->execute([ ':id_film' => $id_film, ':date' => $date , ':seance' => $seance ] );
            $result = $queryes->fetchAll();

        } catch (PDOException $e) {	$data = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }
        if (!empty($result[0]['cinema_seat'])) $data = explode(",", $result[0]['cinema_seat']);
        return $data;
    }


    /**
     * Создаем билеты
     *
     * @param $data
     * @param $cinema_seats
     * @return array|bool|null
     */
    public function createTicket($data, $cinema_seats)
    {
        if (!empty($cinema_seats))
        foreach ($cinema_seats as $cinema_seat) {
            $sql = "INSERT INTO `tikets` (`id_film`, `date_cinema`, `seance`, `cinema_seat`, `email`, `phone`) 
                    VALUES (:id_film, :date_cinema, :seance, :cinema_seat, :email, :phone)";

            try {
                $queryes = $this->pdo->prepare($sql);
                $result = $queryes->execute([
                    ':id_film' => $data['id_film'],
                    ':date_cinema' => $data['date_cinema'],
                    ':seance' => $data['seance'],
                    ':cinema_seat' => $cinema_seat,
                    ':email' => $data['email'],
                    ':phone' => $data['phone'],
                ]);

                if ($result) $results[] = $this->pdo->lastInsertId();

            } catch (PDOException $e) {
                $results = null;
                echo 'Подключение не удалось: ' . $e->getMessage();
                return false;
            }
        }

        return $results;
    }

    /**
     * Получаем ТОП5 самых популярных фильмов.
     *
     * @return bool|null
     */
    public function getTop5()
    {
        $sqlTop5 = "SELECT COUNT(t.`a_id`) as `count`, t.`id_film`, f.`name_film`, f.`poster`, f.`description`
                FROM `tikets` t 
                    LEFT JOIN `films` f ON t.`id_film` = f.`a_id`
                GROUP BY `id_film`
                ORDER BY `count` DESC
                LIMIT 5";

        try {
            $queryesTop5 = $this->pdo->prepare($sqlTop5);
            $queryesTop5->execute();
            $Top5 = $queryesTop5->fetchAll();

        } catch (PDOException $e) {	$Top5 = null;
            echo 'Подключение не удалось: ' . $e->getMessage();
            return false;
        }

        return $Top5;
    }

}