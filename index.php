<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);

function curPageName() {
    return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

include_once('classes/controller.php');
include_once('classes/model.php');
include_once('classes/view.php');

use PM\Controller;
use PM\View;
use PM\Model;

$path = $_SERVER["REQUEST_URI"];
$model = new Model($path);
$controller = new Controller($path);
$view = new View($controller, $model);
$view->unroll();
//?>
