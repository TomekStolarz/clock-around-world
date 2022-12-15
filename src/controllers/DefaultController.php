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

    public function search() {
        $this->render('search');
    }

    public function settings() {
        $this->render('settings');
    }

    public function citydetail() {
        $this->render('city-detail');
    }
}

?>