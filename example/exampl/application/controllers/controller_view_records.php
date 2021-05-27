<?php

class Controller_view_records extends Controller
{
    public function __construct()
    {
        $this->model = new Model_View_Records();
        $this->view = new View();
    }

    function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('view_records_view.php', 'template_view.php',$data,$this->model->CountOfRecords());
    }
}
