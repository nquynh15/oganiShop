<?php

require_once('app/Controllers/Web/WebController.php');


class BlogController extends WebController
{
  public function index()
  {
    return $this->view('blog/index.php');
  }
}
