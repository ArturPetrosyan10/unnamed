<?php
//on server
if(@$_SERVER['USER'] == 'apache') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=example',//37.27.7.153
        'username' => 'root',
        'password' => 'root1234!#',
        'charset' => 'utf8mb4',
        'on afterOpen' => function($event) {
            $event->sender->createCommand("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'")->execute();
        }
    ];
}
//for local
else {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=example',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'on afterOpen' => function($event) {
            // Set the character set and collation after the connection is opened
            $event->sender->createCommand("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'")->execute();
        },
        //'collation' => 'utf8mb4_unicode_ci',
        //'charset' => 'utf8',
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ];
}
