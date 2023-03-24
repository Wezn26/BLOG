<?php


namespace App\Controllers;

use App\Resourses\Pagination;

/**
 * Description of MainController
 *
 * @author leonid
 */
class MainController extends Controller
{
    public function indexAction() 
    {
        //$pagination = new Pagination($this->route, $total);
        $this->view->render('Main Page');
    }
    
    public function aboutAction() 
    {
        $this->view->render('About Page!!!');
    }
    
    public function contactAction() 
    {
        $this->view->render('Contacts!!!');
    }
    
    public function postAction() 
    {
        $this->view->render('Post Page!!!');
    }
}
