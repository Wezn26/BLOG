<?php


namespace App\Models;

use App\Resourses\Db;
use App\View\View;
use Imagick;

/**
 * Description of Admin
 *
 * @author leonid
 */
class Admin 
{
    protected const ADMIN = 'admin';
    protected const TABLE = 'posts';
    public static $error;
    /*
     * @return clean insert data in inputs
     * */
    public static function cleanData($str) 
    {
        return strip_tags(trim($str));
    }
    
    public static function isAdmin($post) 
    {
        if (empty($post['login']) || empty($post['password'])) {
            View::errorcode(404);
        }
        
        $login = static::cleanData($post['login']);
        $adminpass = trim($post['password']);
        
        $db = Db::give();
        $sql = 'SELECT password FROM ' . static::ADMIN . ' WHERE login=:login';
        $data = ['login' => $login];
        $result = $db->row($sql, $data);
        
        if (!$result) {
            static::$error = 'Login or password incorrect!!!';
            return false;
        }
        $password = $result[0]['password'];
        
        if (!password_verify($adminpass, $password)) {
            static::$error = 'Password incorrect!!!';
            return false;
        } else {
            return true;
        }
        
    }
    
    public static function postValidate($post, $type) 
    {
        $nameLength = iconv_strlen($post['name']);
        $descrLength = iconv_strlen($post['description']);
        $textLength =  iconv_strlen($post['text']);
        if ($nameLength < 2 or $nameLength > 100) {
            static::$error = 'Name must starting contain 2 till 100 symbols!!!';
            return false;
        } elseif ($descrLength < 2 or $descrLength > 200) {
            static::$error = 'Name must starting contain 2 till 200 symbols!!!';
            return false;
        } elseif ($textLength < 10 or $textLength > 5000) {
            static::$error = 'Text must starting contain 10 till 5000 symbols!!!';
            return false;
        }
        
        if (empty($_FILES['img']['tmp_name']) && $type == 'add') {
            static::$error = 'No image selected!!!';
            return false;
        }
        return true;
    }
    
    public static function postAdd($post) 
    {
        $db = Db::give();
        $data = [
            'name'        => $post['name'],
            'description' => $post['description'],
            'text'        => $post['text'],
            'date'        => date('d.m.Y')
        ];
        
        $sql = 'INSERT INTO ' . static::TABLE . ' VALUES (:id, :name, :description, :text, :date)';
        $db->query($sql, $data);
        return $db->lastInsertId();
    }
    
    public static function postEdit($post, $id) 
    {
        $db = Db::give();
        $data = [
            'id'          => $id,
            'name'        => $post['name'],
            'description' => $post['description'],
            'text'        => $post['text'],
            'date'        => date('d.m.Y')
        ];
        
        $sql = 'UPDATE ' 
                . static::TABLE . 
                ' SET name=:name, description=:description, 
                      text=:text, date=:date 
                      WHERE id=:id';
        $db->query($sql, $data);
    }
    
      public static function postUploadImage($path, $id) 
    {
        $img = new \Imagick($path);               
        $img->cropThumbnailImage(1080, 600);
        $img->setImageCompressionQuality(80);        
        $img->writeImage('public/uploaded/'.$id.'.jpg');
        //move_uploaded_file($img, 'public/uploaded/' . $id . '.jpg');
    }
    
    public static function isPostExist($id) 
    {
        $db = new Db();
        $data = ['id' => $id];
        $sql = 'SELECT id FROM ' . static::TABLE . ' WHERE id=:id';
        return $db->column($sql, $data);
    }
    
    public static function postDelete($id) 
    {
        $db = Db::give();
        $data = ['id' => $id];
        $sql = 'DELETE FROM ' . static::TABLE . ' WHERE id=:id';
        $db->query($sql, $data);
        unlink('public/uploaded/'.$id.'.jpg');
    }
    
    public static function postData($id) 
    {
        $db = Db::give();
        $data = ['id' => $id];
        $sql = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';
        return $db->row($sql, $data);
    }
}
