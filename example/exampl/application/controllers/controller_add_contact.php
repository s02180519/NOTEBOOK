<?php

class Controller_add_contact extends Controller
{
    public function __construct()
    {
        $this->model = new Model_Add_Contact();
        $this->view = new View();
    }
    function action_index()
    {
        $this->view->generate('add_contact_view.php', 'template_view.php');
        $this->model->get_data();
    }
}
