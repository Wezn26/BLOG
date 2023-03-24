<?php


namespace App\Controllers;

/**
 * Description of AdminController
 *
 * @author leonid
 */
class AdminController extends Controller
{
    /**
     * {@inheritDoc}
     * @see \App\Controllers\Controller::__construct()
     */
    public function __construct($route) 
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }
    
    public function loginAction() 
    {
        $this->view->render('Login Page!!!');
    }
    
    public function addAction() 
    {
        $this->view->render('Add Post!!!');
    }
    
    public function editAction() 
    {
        $this->view-render('Edit Post!!!');
    }
    
    public function deleteAction() 
    {
        echo 'Delete!!!';
    }
    
    public function postsAction() 
    {
        $this->view->render('Post List');
    }
}
