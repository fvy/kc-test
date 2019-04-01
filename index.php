<?php
//use fvy\Korus\Model;
//use fvy\Korus\View;
use fvy\Korus\Template;

require_once 'Psr4Autoloader.php';
require_once 'config.php';

/*
$newspaper = new Model('Newyork Times');
$allen = new View('Allen');
//add reader
$newspaper->attach($allen);
//set break outs
$newspaper->breakOutNews('USA break down!');
*/

$view = new Template("Layout");
$view->title = "Отчет по сотрудникам";
$view->properties['name'] = "Список пользователей";

$dbMapper = new fvy\Korus\Db\DbMapper($conn);
$view->data = $dbMapper->usersList($_POST["startDate"] ?? null ,$_POST["endDate"] ?? null);
echo $view->render('Layout');