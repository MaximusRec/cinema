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
     * Пагинацию не делал? нет в ТЗ, сделаю лимит 50, т.к. в кинотеатре одновременно больше премьер не ожидается.
     *
     * @return bool|null
     */
    public function getFilms()
    {
        $sql = "SELECT `a_id`, `name_film`, `poster`, `description`, `date_added` FROM `films` f ORDER BY `date_added` ASC LIMIT 50";

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