<?php 

require_once('app/Controllers/Web/WebController.php');
require_once('app/Middlewares/Authenticated.php');
require_once('app/Models/Cart.php');

class ShopcartController extends WebController
{
    protected $cart; 

    public function __construct()
    {
        $this->cart = new Cart();
    }

    public function add()
    {
        if ($this->middleware('Authenticated')) {
            // print_r('123');die();
            $id = $_GET['id'];
            $this->cart->addCartItem($id);
            return redirect('shopcart/index');
        }
    }

    public function index()
    {
        if ($this->middleware('Authenticated')) {
            $cartItems = $this->cart->getCartItems();
            return $this->view('shopcart/index.php', ['cartItems' => $cartItems]);
        }    
    }

    public function modify()
    {
        if (isset($_POST['update'])) {
            $this->update($_GET['id'], $_POST['quantity']);
        }

        if (isset($_POST['delete'])) {
            $this->delete($_GET['id']);
        }
    }

    public function update($id, $quantity)
    {
        $this->cart->updateCartItem($id, $quantity);
        return redirect('shopcart/index');
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->cart->deleteCartItem($id);
        return redirect('shopcart/index');
    }
}