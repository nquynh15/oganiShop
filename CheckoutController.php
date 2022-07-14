<?php 

require_once('app/Controllers/Web/WebController.php');
require_once('app/Models/Cart.php');

// require_once('app/Models/Model.php');

class CheckoutController extends WebController
{
    private $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }
    public function index()
    {
        $cartItems = $this->cart->getCartItems();
        
        return $this->view('checkout/index.php', ['cartItems' => $cartItems]);
    }

    public function districts()
    {
        $maTP = $_GET['matp'];
        $districts = $this->district->where(['matp' => $maTP])->hydrate();
        return $this->ajax(['districts' => $districts]);
    }

    public function wards()
    {
        $maqh = $_GET['maqh'];
        $wards = $this->wards->where(['maqh' => $maqh])->hydrate();
        return $this->ajax(['wards' => $wards]);
    }
}