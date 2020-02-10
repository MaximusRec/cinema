<?php
date_default_timezone_set('Europe/Kiev');
class Controller_Admin extends Controller
{
    function __construct()
    {
        $this->model = new Model_Admin();
        $this->view = new View();
    }

    function action_index()
    {
        if ( $this->authorization() !== TRUE ) {
            $this->redirect ( 'user' );
        }

        $this->view->generate('admin_index_view.php', 'template_view.php' );
    }

    /**
     * Показываем список всех фильмов
     */
    function action_films()
    {
        if ( $this->authorization() !== TRUE ) {
            $this->redirect ( 'user' );
        }

        $data['films'] = $this->model->getFilms();

        $data['action'] = "/admin/films";

        if (isset($_POST['new'])) {
            $this->redirect('admin/newfilm'); //  переходим к созданию нового фильма
        }

        if (isset($_POST['del']) AND !empty($_POST['films'])) { //  если нажата кнопка удаления и выбраны ид фильмов то удаляем
            $listFilms = $_POST['films'];
            $data['result_del'] = $this->model->delFilms($listFilms);
            if ($data['result_del'] == 1) {
                $data['message'] = "Удалении прошло успешно";
                $this->redirect ( 'admin/films' );  //  редирект на список фильсов
            } else $data['message'] = "Ошибка удаления";
        }

        $this->view->generate('admin_films_view.php', 'template_view.php', $data );
    }

    /**
     * Изменяем данные фильма
     */
    function action_editfilm()
    {
        if ( $this->authorization() !== TRUE ) {
            $this->redirect ( 'user' );
        }

        if (!empty($_POST)) $data = $_POST;
        $data['edit'] = 1;

        if (isset($_GET['id'])) {
            $data['id_film'] = $_GET['id'];
        } elseif ($_POST['a_id']) {
            $data['id_film'] = $_POST['a_id'];
        } else { $data['id_film'] = 1; }

        $film = $this->model->getFilm($data['id_film']);

        $data['film'] = $film[0];

        $data['action'] = "/admin/editfilm";

        $data['seances'] = $this->model->getAllSeance();   //  получаем все сеансы существующие

        $data['film_seances'] = explode(",", $data['film']['all_seances']);  ;   //  получаем сеансы этого фильма

        $data['poster'] = $data['film']['poster'];

        if(isset($_FILES['poster_file'])) {
            $check = $this->can_upload($_FILES['poster_file']);
            if($check === true){
                // загружаем изображение на сервер
                $data['poster'] = $this->make_file($_FILES['poster_file']);
            } else {
                $data['message'] = "Error load file";
            }
        }

        //  Сохраняем данные о фильме
        if (isset($_POST['save']) AND !empty($_POST['a_id'])) {
            $this->model->editFilm($data);
            if (isset($_POST['film_seances']) AND !empty($_POST['film_seances'])) { //  сохраняем сеансы
                $this->model->saveSeances($data['id_film'], $_POST['film_seances']);
            }

            $this->redirect ( 'admin/films' );
        }

        $this->view->generate('admin_edit_film_view.php', 'template_view.php', $data );
    }

    /**
     * Создаем новый фильм
     */
    function action_newfilm()
    {
        if ( $this->authorization() !== TRUE ) {
            $this->redirect ( 'user' );
        }

        if (!empty($_POST)) $data = $_POST;
        $data['new'] = 1;
        $data['action'] = "/admin/newfilm";

        if(isset($_FILES['poster_file'])) {
            $check = $this->can_upload($_FILES['poster_file']);
            if($check === true){
                // загружаем изображение на сервер
                $data['poster'] = $this->make_file($_FILES['poster_file']);
            } else {
                $data['message'] = "Error load file";
            }
        } else {  $data['poster'] = '/images/poster/unnamed.png'; }

        if ( strtotime($data['date_end']) < strtotime($data['date_start'])) { // если дата начала меньше даты конца, то выдаем ошибку и не сохраняем
            $data['message'] =  "Дата окончание не может быть раньше даты завершения!";
        } else {
            if (isset($_POST['create']) AND !empty($data)) {
                $id_film = $this->model->createFilm($data);
                $this->redirect('admin/editfilm?id=' . $id_film);       //  переходим к редактированию этого фильма
            }
        }

        $this->view->generate('admin_edit_film_view.php', 'template_view.php', $data );
    }

    /**
     * Проверяем файл перед загрузкой
     *
     * @param $file
     * @return bool|string
     */
    private function can_upload($file)
    {
        if($file['name'] == '') // если имя пустое, значит файл не выбран
            return 'Вы не выбрали файл.';

        if($file['size'] == 0)
            return 'Файл слишком большой.';

        $getMime = explode('.', $file['name']);        // разбиваем имя файла по точке и получаем массив

        $mime = strtolower(end($getMime));        // нас интересует последний элемент массива - расширение

        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');        // объявим массив допустимых расширений

        if(!in_array($mime, $types))
            return 'Недопустимый тип файла.';

        return true;
    }

    /**
     * Загружаем постер
     *
     * @param $file
     * @return string
     */
    private function make_file($file){
        $name_path =  $_SERVER['DOCUMENT_ROOT'] . $name = '/images/poster/' . $file['name'];
        copy($file['tmp_name'], $name_path);

        return $name;
    }

//======================================================

    /**
     * Админ часть просмотра кол-ва купленных билетов
     *
     * @throws Exception
     */
    function action_viewtiket()
	{
        if ( $this->authorization() !== TRUE ) {
            $this->redirect ( 'user' );
        }
            $id_film = 0;
            $data = [];

            if ($_POST['id_film']) $id_film = $_POST['id_film']-1;
            $data['id_film'] = $id_film;
            $data['action'] = "/viewtiket";
            $data['films'] = $this->model->getFilms();
                //  list date
                $from = new DateTime($data['films'][$id_film]['date_start']);
                $to   = new DateTime($data['films'][$id_film]['date_end']);

                $period = new DatePeriod($from, new DateInterval('P1D'), $to);

            $data['dates'] = array_map(
                    function($item){return $item->format('Y-m-d');},
                    iterator_to_array($period)
                );

            if (empty($_POST['select_date'])) $data['select_date'] = $data['films'][$id_film]['date_start']; else $data['select_date'] = $_POST['select_date'];

            $data['tiket'] = $this->model->getTiketByFilm($id_film, $data['select_date']);

            $this->view->generate('view_tiket_view.php', 'template_view.php', $data );

	}

    /**
     * Геренирует данные за день по сеансам и купленным местам
     */
    function action_seanses()
    {
        $data['tiket'] = $this->model->getTiketByFilm($_POST['id_film'], $_POST['select_date']);
        $data['date'] =  date_format( date_create($_POST['select_date']), 'd.m.Y');

        $this->view->generate('dayseanses_view.php', 'templatenull_view.php', $data );
    }

    /**
     * Генерируем список дат в json для дальнейшей отправки в jQuery для дальнейшей модификации
     * списка доступных дат показа для каждого фильма
     *
     * @throws Exception
     */
    function action_datesfilm()
    {
        $films = $this->model->getFilm($_POST['id_film']);

        $from = new DateTime($films[0]['date_start']);
        $to   = new DateTime($films[0]['date_end']);

        $period = new DatePeriod($from, new DateInterval('P1D'), $to);
        //  получаем список дат показа фильма
        $data['dates'] = array_map(
            function($item){return $item->format('Y-m-d');},
            iterator_to_array($period)
        );

        $this->view->generate('datesfilm_view.php', 'templatenull_view.php', $data );
    }

}