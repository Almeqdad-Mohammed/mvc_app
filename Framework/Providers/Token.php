<?php
  
    namespace Framework\Providers;
    // require_once 'Framework/Providers/Session.php';
    
    require_once 'helpers.php';

    class Token{

        public static function generateCsrfToken(){

            return Session::put(config('token_name'), bin2hex(openssl_random_pseudo_bytes(64)));

        }

        public static function checkCsrfToken($token){
            if (Session::exists(config('token_name')) && Session::get(config('token_name')) === $token) {
                Session::delete(config('token_name'));
                return true;
            }

            return false;
        }
    }