<?php
    use Framework\Core\Controller;
    class Home extends Controller {

        public function index($name = ''){

            $user  = $this->model('testing');
            $user->test = $name;
            
            $this->view('frontend/index', ['name' => $user->test]);
        }
    }