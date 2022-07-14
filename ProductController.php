<?php 

require_once('app/Controllers/Web/WebController.php');
require_once('app/Models/Product.php');

class ProductController extends WebController
{
    private $product; 

    public function __construct()
    {
        $this->product = new Product();
    }
    public function show()
    {
        $id = $_GET['id'];

        $product = $this->product->find($id)->hydrate();
        return $this->view('detailproduct/detailProduct.php', ['product' => $product]);
    }
}