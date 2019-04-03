<?php


namespace fvy\Korus\Db;


class DbConnection
{
    /**
     * @var DbConfiguration
     */
    private $configuration;

    /**
     * @param DbConfiguration $config
     */
    public function __construct(DbConfiguration $config)
    {
        $this->configuration = $config;
    }

    public function getDsn()
    {
        try {
            $connection = new \PDO("mysql:dbname={$this->configuration->getDatabase()};host={$this->configuration->getHost()}",
                $this->configuration->getUsername(),
                $this->configuration->getPassword(),
                array(
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );
        } catch (\PDOException $e) {
            die('Unable to open database connection' . $e->getTrace());
        }
        return $connection;
    }
}