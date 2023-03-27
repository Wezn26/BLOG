<?php
//require './helper.php';
require './autoload.php';

session_start();


$router = new \App\Router\Router();
$router->run();

