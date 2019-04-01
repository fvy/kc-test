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
        // this is just for the sake of demonstration, not a real DSN
        // notice that only the injected config is used here, so there is
        // a real separation of concerns here

        /*
            return sprintf(
            '%s:%s@%s:%d',
            $this->configuration->getUsername(),
            $this->configuration->getPassword(),
            $this->configuration->getDatabase(),
            $this->configuration->getHost(),
            $this->configuration->getPort()
        );
        */
        $connection = new \PDO("mysql:dbname={$this->configuration->getDatabase()};host={$this->configuration->getHost()}",
            $this->configuration->getUsername(),
            $this->configuration->getPassword(),
            array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            )
        );
        /* change character set to utf8 */
        return $connection;
    }
}