<?php

$host = 'localhost';
$dbname = 'test';
$username = 'root';
$password = '';

return array(
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
        'aliases' => array(
            'zend_db_adapter' => 'Zend\Db\Adapter\Adapter'
        ),
    ),
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => "mysql:dbname=$dbname;host=$host",
        'username' => $username,
        'password' => $password,
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        ),
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host' => $host,
                    'port' => '3306',
                    'user' => $username,
                    'password' => $password,
                    'dbname' => $dbname,
                )
            )
        )
    ),
);