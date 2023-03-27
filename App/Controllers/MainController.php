<?php


namespace App\Controllers;

use App\Models\Admin;
use App\Models\Main;
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
        $pagination = new Pagination($this->route, Main::postsCount(), 2);
        $vars = [
            'pagination' => $pagination->get(),
            'list' => Main::postsList($this->route)
        ];
        $this->view->render('Main Page', $vars);
    }
    
    public function aboutAction() 
    {
        $this->view->render('About Page!!!');
    }
    
    public function contactAction() 
    {
        if (!empty($_POST)) {
            if (!Main::contactValidate($_POST)) {
                $this->view->message('error', Main::$error);
            }
            mail('hedasap318@wiroute.com',
                'Сообщение из блога', $_POST['name'].'|'.$_POST['email'].'|'.$_POST['text']);
            $this->view->message('success', 'Message Sending for Administrator!!!');
        }
        $this->view->render('Contacts!!!');
    }
    
    public function postAction() 
    {
        if (!Admin::isPostExist($this->route['id'])) {
            $this->view->errorcode(404);
        }
        $vars = ['data' => Admin::postData($this->route['id'])[0]];
        $this->view->render('Post Page!!!', $vars);
    }
}
