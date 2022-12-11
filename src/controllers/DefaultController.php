<?php 

require_once 'AppController.php';

class DefaultController extends AppController {
    public function start() {
        $this->render('login');
    }
    
    public function register() {
        $this->render('register');
    }

    public function dashboard() {
        $this->render('dashboard');
    }

    public function adminpanel() {
        $this->render('admin-panel');
    }
}

?>