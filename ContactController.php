<?php
require_once('app/Controllers/Web/WebController.php');
require_once('app/Models/Contact.php');


class ContactController extends WebController
{
  protected $contact;

  public function __construct()
  {
    $this->contact = new Contact();
  }

  public function index()
  {
    return $this->view('contact/index.php');
  }

  public function success()
  {
    return $this->view('contact/success.php');
  }
  
  public function create()
  {
    
    $this->contact->create($_POST);
    return redirect('contact/success');
  }
}
