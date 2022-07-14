<?php 

require_once('app/Controllers/Web/WebController.php');
require_once('app/Models/OrderDetail.php');
require_once('app/Models/Order.php');
require_once('app/Models/Cart.php');
require_once('core/Auth.php');

class OrderController extends WebController
{
    public function create()
    {
        

        
        $cart = new Cart();
        $cartItems = $cart->getCartItems();
        $total = 0;
        foreach ($cartItems as $cartItem) 
        {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }
        $order = new Order();
        
        // $_POST['order_id'] = "". $currentDate->format('YmdHis');
        
        $_POST['user_id'] = Auth::getUser('user')['user_id'];
        $_POST['subtotal'] = $total;
        
        $recentCreatedOrder = $order->create($_POST);

        
        
        $orderDetail = new OrderDetail();
        $data = [];
        foreach ($cartItems as $productId => $cartItem) 
        {
            $data['product_id'] = $productId;
            $data['order_id'] = $recentCreatedOrder['id'];
            $data['quantity'] = $cartItem['quantity'];
            $data['product_name'] = $cartItem['name'];
            $data['total'] = $cartItem['price'] * $cartItem['quantity'];
            
            $orderDetail->create($data);
        }

        $cart->clearCartSession();
        
        return redirect('order/success');
        
    }

    public function success()
    {
        return $this->view('order/success.php');
    }
}