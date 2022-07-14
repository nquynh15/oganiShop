<?php
require_once('app/Controllers/Web/WebController.php');
require_once('app/Requests/Web/AuthenticationRequest.php');
require_once('core/Flash.php');
require_once('app/Models/User.php');
require_once('core/Auth.php');

class AuthenticationController extends WebController
{
  private $user;

  public function __construct()
  {
    $this->user = new User();
  }

  public function index()
  {
    return $this->view('authentication/show-login-form.php');
  }

  public function showLoginForm()
  {
    return $this->view('authentication/show-login-form.php');
  }

  public function login()
  {
    if (isset($_POST['login'])) {
      $loginRequest = new AuthenticationRequest();
      $login_errors = $loginRequest->validateLogin($_POST);
      
      if (count($login_errors) == 0) {
        $user = $this->user->where(['email' => $_POST['email'], 'password' => md5($_POST['password'])])->first();
        if (!empty($user)) {
          Auth::setUser('user', $user, isset($_POST['remember_me']) ? true : false);
          return redirect('homepage/index');
        }
        Flash::set('error', 'Sai thông tin đăng nhập');
        return redirect('authentication/showLoginForm');
      }

      return $this->view('authentication/show-login-form.php', ['errors' => $loginRequest->getErrors()]);
    }

    if(isset($_POST['register'])){
      return redirect('authentication/showRegisterForm');
    }

    return redirect('authentication/showLoginForm');
  }

  public function showRegisterForm()
  {
    return $this->view('authentication/show-register-form.php');
  }

  public function register()
  {
    if (isset($_POST['register'])) {
      $registerRequest = new AuthenticationRequest();
      $register_errors = $registerRequest->validateRegister($_POST);
      
      if (count($register_errors) == 0) {
        $_POST['password'] = md5($_POST['password']);
        $isCreated = $this->user->create($_POST);
        if ($isCreated) {
          $this->user->where(['email' => $_POST['email']])->first();
          Auth::setUser('user', $isCreated);
          return redirect('authentication/showLoginForm');
        }
      }
      return $this->view('authentication/show-register-form.php', ['errors' => $registerRequest->getErrors()]);
    }
    return redirect('authentication/showRegisterForm');
  }

  public function logout()
  {
    Auth::logout('user');
    return redirect('homepage/index');
  }
}
