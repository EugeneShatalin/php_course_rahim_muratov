<?php
    $config = include  __DIR__ . '/config.php';  
    include  __DIR__ . '/Connection.php';
    include  __DIR__ . '/QueryBuilder.php';

    return new QueryBuilder(Connection::make($config['database']));