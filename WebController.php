<?php 

require_once('app/Controllers/Controller.php');

class WebController extends Controller
{
    public function view($view, $data = []) 
    {
        return render("web/$view", $data);
    }
}