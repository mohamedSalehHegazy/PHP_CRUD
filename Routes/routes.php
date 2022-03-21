<?php
$request = preg_replace("|/*(.+?)/*$|", "\\1", $_SERVER['PATH_INFO']);
$uri = explode('/', $request);

$uri0 = isset($uri[0]);
$uri1 = isset($uri[1]);

require_once "Config/Database.php";
require_once "Controllers/UsersController.php";
require_once "Models/User.php";
$db = new Database();
$model = new User($db);
$controller = new UsersController($model);

/**
 * Routes 
 */

if($uri0 && $uri1 && $uri[0] === 'users'&& $uri[1] === 'show') {         // Show
    $id = $_GET['id'];
    $controller->show($id);
} elseif ($uri0 && $uri1 && $uri[0] === 'users' && $uri[1] === 'update') {     // update
    $id = $_GET['id'];
    $controller->edit($id);
} elseif ($uri0 && $uri1 && $uri[0] === 'users' && $uri[1] === 'delete') {   // Delete
    $id = $_GET['id'];
    $controller->delete($id);
} elseif ($uri0 && $uri1 && $uri[0] === 'users' && $uri[1] === 'create') {   // Create
    $controller->create();
} elseif ($uri[0] === 'users') {                                             // Index
    $controller->index();
} else {
    header('HTTP/1.1 404 Not Found');
    echo '<html><body><h1>404</h1><br><br><h2><center>Not Found 404</center></h2></body></html>';
}