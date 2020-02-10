<?php

class Controller_Main extends Controller
{
    function __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
    }

    function action_index()
	{   $data = [];
	        $data['top5'] = $this->model->getTop5();
            $data['films'] = $this->model->getFilms();

            $this->view->generate('main_view.php', 'template_view.php', $data );
	}

    /**
     * Просматриваем выбранный фильм
     *
     * @throws Exception
     */
    function action_view()
    {   $data = [];
        if (isset($_GET['id'])) {
            $data['id_film'] = $_GET['id'];
        } else { $data['id_film'] = 1; }
        $data['film'] = $this->model->getFilm($data['id_film']);
        if (!empty($data['film']['film_seances'])){
            $data['film_seances'] = $this->model->getTimeSeance(explode(",",$data['film']['film_seances']));
        }

        $data['action'] = '/main/payticket/';

        //  list date
        if (($data['film']['date_start']) AND !empty($data['film']['date_end'])) {
            $from = new DateTime($data['film']['date_start']);
            $to   = new DateTime($data['film']['date_end']);

            $period = new DatePeriod($from, new DateInterval('P1D'), $to);

            $data['list_dates'] = array_map(
                function($item){return $item->format('Y-m-d');},
                iterator_to_array($period)
            );
        }

        $this->view->generate('film_view.php', 'template_view.php', $data );
    }

    /**
     * Генерируем места для зада, занятые неактивны
     */
    function action_view_cinema_ceanse()
    {   $data = [];

        if (!empty($_POST['a_id']) AND !empty($_POST['select_date']) AND !empty($_POST['select_seance']) ) {
            $buyTiket = $this->model->getFilmBuyTicket($_POST['a_id'], $_POST['select_date'], $_POST['select_seance']);
            for ($i = 1; $i <=50; $i++) {
                $placeCinema[$i] = 1;
                if (!empty($buyTiket))
                if (in_array($i, $buyTiket)) {
                    $placeCinema[$i] = 0;
                }
            }
            $data['placeCinema'] = $placeCinema;

            $this->view->generate('view_cinema_ceanse_view.php', 'templatenull_view.php', $data );
        } else {
            $this->view->generate('templatenull_view.php', 'templatenull_view.php', $data );
        }
    }

    /**
     * Форма конечного заказа билета
     */
    function action_payticket()
    {
        $data = $add_record = [];
        $data = $_POST;
        $data['action'] = '/main/payticket/';

        if (!empty($_POST) AND isset($_POST['buy'])) {
            $cinema_seats = unserialize($_POST['cinema_seats_json']);
            $add_record = $this->model->createTicket($data, $cinema_seats);
            if (!empty($add_record)) {
                $data['message'] = "Были успешно куплено ".count($add_record)." билетов";
            } else {
                $data['message'] = "Ошибка покупки билетов";
            }
            $data['buyok'] = 1;
        } else {
            if (!empty($data['select_seance'])) {
                $listSeances = $this->model->getTimeSeance([$data['select_seance']]);
                $data['seance'] = $listSeances[$data['select_seance']];
            }
            if (!empty($data['cinema_seats'])) {
                $data['count_cinema_seats'] = count($data['cinema_seats']);
                $data['cinema_seats_json'] = serialize($data['cinema_seats']);
                $data['cinema_seats'] = implode(", ", $data['cinema_seats']);
            }
        }

        $this->view->generate('payticket_view.php', 'template_view.php', $data );
    }
}