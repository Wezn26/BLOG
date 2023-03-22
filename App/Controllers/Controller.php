<?php


namespace App\Controllers;

use App\View\View;

/**
 * Description of Controller
 *
 * @author leonid
 */
abstract class Controller 
{
    public $route;
    public $view;
    public $access;
    
    public function __construct($route) 
    {
        $this->route = $route;
        if (!$this->checkAccess()) {
            View::errorcode(403);
        }
        $this->view = new View($route);
    }
    
    public function checkAccess() 
    {
        $this->access = require 'App/Router/access/' . $this->route['controller'] . '.php';
        if ($this->isAccess('all')) {
            return true;
        } elseif (isset ($_SESSION['authorize']['id']) && $this->access['authorize']) {
            return true;
        } elseif (!isset ($_SESSION['authorize']['id']) && $this->access['guest']) {
            return true;
        } elseif (isset ($_SESSION['admin']) && $this->access['admin']) {
            return true;
        }
        return false;
    }
    
    public function isAccess($key) 
    {
        return in_array($this->route['action'], $this->access[$key]);
    }
}
