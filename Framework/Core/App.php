<?php
namespace Framework\Core;
class App{
    private $controller = "home",
            $method = "index",
            $params = [];

    public function __construct(){
        $url = $this->parseUrl();

        if (isset($url[0])) {
            if ($url[0] === 'Dashboard') {
                # GO To Admiin Side 
                unset($url[0]);
                if (file_exists('App/Controller/Dashboard/'. $url[1] .'.php')) {
                    $this->controller = $url[1];
                    unset($url[1]);
                    require_once 'App/Controller/Dasboard/' . $this->controller .'.php';
                    $this->controller = new $this->controller;

                    if (isset($url[2])) {

                        if (method_exists($this->controller, $url[2])) {
                        
                            $this->method = $url[2];
                            unset($url[2]);

                            $this->params = $url ? array_values($url) : [];

                            call_user_func_array([$this->controller , $this->method] , $this->params);

                        }

                    }else {
                        # code... Do somthing for redirect page
                       
                    }
                }else {
                    # code... not found
                    echo "404";
                }
                echo "Welcome Admin";
            }else {
                
                if(file_exists('App/Controller/' . $url[0] .'.php')) {
                    $this->controller = $url[0];
                    unset($url[0]);
                    require_once 'App/Controller/' . $this->controller .'.php';
                    $this->controller = new $this->controller;

                    if (isset($url[1])) {
                        if (method_exists($this->controller, $url[1])) {
                            
                            $this->method = $url[1];
                            unset($url[1]);

                            $this->params = $url ? array_values($url) : [];
                           
                            call_user_func_array([$this->controller , $this->method] , $this->params);

                        }else {
                            // do else 
                            echo "404";
                        }
                    }else {
                        # Temp Code
                    }
                }else {
                    # Not fount page Like 
                    echo "404";
                }
            }
        }else{
            // Do Somthing
        }
    }

    public function parseUrl(){
        if (isset($_GET['url'])) {
           return explode('/' , rtrim(filter_var($_GET['url'], FILTER_SANITIZE_URL) , '/'));
        }
    }
}