<?php

use Fvy\Korus\Template;
use Fvy\Korus\Db\DbMapper;

require_once 'Psr4Autoloader.php';
require_once 'config.php';

$view = new Template("Layout");
$view->title = "Отчет по сотрудникам";
$view->properties['name'] = "Список пользователей";

$dbMapper = new DbMapper($conn);
$view->data = $dbMapper->usersList($_POST["startDate"] ?? null, $_POST["endDate"] ?? null);
$view->dataOfTs = $dbMapper->checkUserMissedHours();

echo $view->render('Layout');