<?php 

require_once 'AppController.php';

class DefaultController extends AppController {
    public function start() {
        $this->render('login');
    }
    
    public function register() {
        $this->render('register');
    }

    public function adminpanel() {
        $this->render('admin-panel');
    }

    public function search() {
        $this->render('search');
    }

    public function settings() {
        $this->render('settings');
    }

}

?>