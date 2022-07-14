<?php 
require ('./traits/Middleware.php');

class Controller 
{
    use Middleware;
    
    public function ajax($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        if ($statusCode >= 200 && $statusCode <= 300) {
            echo json_encode([
                'status' => 1,
                'data' => $data
            ]);
            return;
        }
        echo json_encode([
            'status' => 0
        ]); 
    }
}