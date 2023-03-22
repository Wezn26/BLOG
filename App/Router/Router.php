<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Router;

use App\View\View;

/**
 * Description of Router
 *
 * @author leonid
 */
class Router 
{
    protected $routes = [];
    protected $params = [];
    
    public function __construct() 
    {
        $arr = require 'routes.php';
        foreach ($arr as $key => $value) {
            $this->add($key, $value);
        }
        
    }
    
    public function add($route, $params) 
    {
       $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
       $route = '#^'. $route . '$#';
       $this->routes[$route] = $params;
    }
    
    public function match() 
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int) $match;
                        }
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
    
    
    public function run() 
    {
        if ($this->match()) {
            $path = '\App\Controllers\\' . 
                    ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorcode(404);
                }
            } else {
                View::errorcode(404);
            }
        } else {
            View::errorcode(403);
        }
    }
}
