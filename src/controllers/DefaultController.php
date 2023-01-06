<?php 

require_once 'AppController.php';

class DefaultController extends AppController {
    
    public function register() {
        $this->render('register');
    }

    public function search() {
        $this->render('search');
    }

    public function settings() {
        $this->render('settings');
    }

}

?>