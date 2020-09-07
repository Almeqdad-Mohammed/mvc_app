<?php
session_start();
    spl_autoload(function($class){
        require_once 'Core/' . $class. '.php';
        require_once 'Providers'. $class . '.php';
    });

    require_once 'helpers.php';