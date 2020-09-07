<?php
    session_start();
    require 'vendor/autoload.php';
     use Framework\Core\Module;
//    use Framework\Providers\Token;

    $user = new Module();
    $user->dbcon();

    $user->create('users', [
        "username" => 'HAmoda',
        "phone" => '1220Testing'
    ]);

    $userTest =   $user->result();
    $count = $user->count();
    echo "<pre>";
    print_r($userTest);
    echo "</pre>";


