<?php

 // function  to get config

 function config($config = null){
     if ($config) {
         $app_config  = require 'config/app.php';

         $config = explode('/' , $config);

         foreach ($config as $conf) {
             $app_config = $app_config[$conf];
         }
         return $app_config;
     }

     return false;
 }