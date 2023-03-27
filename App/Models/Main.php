<?php


namespace App\Models;

use App\Resourses\Db;

/**
 * Description of Main
 *
 * @author leonid
 */
class Main 
{
    protected const TABLE = 'posts';
    public static $error;
    
    public static function contactValidate($post) 
    {
        $nameLenght = iconv_strlen($_POST['name']);
        $textLenght = iconv_strlen($_POST['text']);
        
        if ($nameLenght < 2 || $nameLenght > 20) {
            static::$error = 'Name must starting contain 2 till 20 symbols!!!';
            return false;
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            static::$error = 'Email is incorrect!!!';
            return false;
        } elseif ($textLenght < 10 || $textLenght > 500) {
            static::$error = 'Message must starting contain 10 till 500 symbols!!!';
            return false;
        }
        return true;
    }
    
    public static function postsCount() 
    {
        $db = new Db();
        $sql = 'SELECT COUNT(id) FROM ' . static::TABLE;
        return $db->column($sql);
    }
    
    public static function postsList($route) 
    {
        $max = 2;
        $db = new Db();
        $data = [
            'max'   => $max,
            'start' => ((($route['page'] ?? 1) - 1) * $max),
        ];
        
        $sql = 'SELECT * FROM ' . static::TABLE . ' ORDER BY id DESC LIMIT :start, :max';
        return $db->row($sql, $data);
    }
}
