<?php



namespace App\View;

/**
 * Description of View
 *
 * @author leonid
 */
class View 
{
    public $path;
    public $route;
    public $layout = 'default';
    
    public function __construct($route) 
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['action'];
    }
    
    public function render(string $title, array $vars = []) 
    {
        extract($vars);
        $file = 'App/View/' . $this->path . '.php';
        if (file_exists($file)) {
            ob_start();
            require $file;
            $content = ob_get_clean();
            require 'App/View/layouts/' . $this->layout . '.php';
        } else {
            echo 'Not Found View: ' . $this->path;
        }
    }
    
    public function redirect($url) 
    {
        header('Location: /' . $url);
        exit();
    }
    
    public static function errorcode($code) 
    {
        http_response_code($code);
        $file = 'App/View/errors/' . $code . '.php';
        if (file_exists($file)) {
            require $file;
        }
        exit();
        
    }
    
    public function message($status, $message) 
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }
    
    public function location($url) 
    {
        exit(json_encode(['url' => $url]));
    }
    
    
}
