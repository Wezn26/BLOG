<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Traits;

/**
 * Description of Singleton
 *
 * @author leonid
 */
trait Singleton 
{
    protected static $instance = null;
    
    public static function give() 
    {
        if (null === static::$instance) {
            return static::$instance = new static;
        }
    }
}
