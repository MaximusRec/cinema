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

}