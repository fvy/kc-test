<?php

use Fvy\Korus\Db\DbConfiguration;
use Fvy\Korus\Db\DbConnection;
use Fvy\Psr4Autoloader;

const TEMPLATE_PATH = __DIR__ . '/src/Views';

$loader = new Psr4Autoloader;
// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('Fvy\Korus', __DIR__ . '/src');
$loader->addNamespace('Fvy\Korus', __DIR__ . '/tests');

//DB connection
$dbConf = new DbConfiguration(
    "localhost",
    3306,
    "korus",
    "korus",
    "B3uv13*k");

$dbConn = new DbConnection($dbConf);
$conn = $dbConn->getDsn();