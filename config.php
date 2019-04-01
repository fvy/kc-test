<?php

use fvy\Korus\Db\DbConfiguration;
use fvy\Korus\Db\DbConnection;
use fvy\Psr4Autoloader;

const TEMPLATE_PATH = __DIR__ . '/src/Views';

$loader = new Psr4Autoloader;
// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('fvy\Korus', __DIR__ . '/src');
$loader->addNamespace('fvy\Korus', __DIR__ . '/tests');

//DB connection
$dbConf = new DbConfiguration(
    "localhost",
    3306,
    "korus",
    "korus",
    "B3uv13*k");

$dbConn = new DbConnection($dbConf);
$conn = $dbConn->getDsn();