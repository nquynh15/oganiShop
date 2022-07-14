<?php

require_once('app/Controllers/Web/WebController.php');


class HomePageController extends WebController
{
    public function index()
    {
        return $this->view('homepage/index.php');
    }
}
