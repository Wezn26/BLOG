<?php


namespace App\Controllers;

use App\Models\Admin;
use App\Models\Main;
use App\Resourses\Pagination;

/**
 * Description of AdminController
 *
 * @author leonid
 */
class AdminController extends Controller
{
    /**
     * {@inheritDoc}
     * @see Controller::__construct()
     */
    public function __construct($route) 
    {
        parent::__construct($route);
        $this->view->layout = 'admin';
    }
    
    public function loginAction() 
    {
        if (isset($_SESSION['admin'])) {
            $this->view->redirect('admin/add');
        }
        if (!empty($_POST)) {
            if (!Admin::isAdmin($_POST)) {
                $this->view->message('error', Admin::$error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
        }
        $this->view->render('Login Page!!!');
    }
    
    public function addAction() 
    {
        if (!empty($_POST)) {
            if (!Admin::postValidate($_POST, 'add')) {
                $this->view->message('error', Admin::$error);
            }
            $id = Admin::postAdd($_POST);
            if (empty($id)) {
                $this->view->message('Request processing error', Admin::$error);
            }
            
            Admin::postUploadImage($_FILES['img']['tmp_name'], $id);
            
            $this->view->message('success', 'Downloaded!!!');
        }
        $this->view->render('Add Post!!!');
    }
    
    public function editAction() 
    {
        if (!Admin::isPostExist($this->route['id'])) {
            $this->view->errorcode(404);
        }
        if (!empty($_POST)) {
            if (!Admin::postValidate($_POST, 'edit')) {
                $this->view->message('error', Admin::$error);
            }
            Admin::postEdit($_POST, $this->route['id']);
            if (!empty($_FILES['img']['tmp_name'])) {
                Admin::postUploadImage($_FILES['img']['tmp_name'], $this->route['id']);
            }
            $this->view->message('success', 'Saved!!!');
        }
        
        $vars = ['data' => Admin::postData($this->route['id'])[0]];
        $this->view-render('Edit Post!!!', $vars);
    }
    
    public function deleteAction() 
    {
        if (!Admin::isPostExist($this->route['id'])) {
            $this->view->errorcode(404);
        }
        Admin::postDelete($this->route['id']);
        $this->view->redirect('admin/posts');
    }
    
    public function logoutAction() 
    {
        unset($_SESSION['admin']);
        $this->view->redirect('admin/login');
    }
    
    public function postsAction() 
    {
        $pagination = new Pagination($this->route, Main::postsCount(), 2);
        $vars = [
            'pagination' => $pagination->get(),
            'list' => Main::postsList($this->route)
        ];
        $this->view->render('Post List', $vars);
    }
}
