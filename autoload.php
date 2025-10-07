<?php
spl_autoload_register(function ($class) {
    $classPaths = [
        __DIR__ . '/class/Abstracts/' . $class . '.php',
        __DIR__ . '/class/' . str_replace('class\\', '', $class) . '.php',
        __DIR__ . '/class/' . $class . '.php'
    ];

    foreach ($classPaths as $classPath) {
        //echo $classPath.'<br>';
        if (file_exists($classPath)) {
            require_once $classPath;
            break;
        }
    }
});