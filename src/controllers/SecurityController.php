<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';

class SecurityController extends AppController {
    
   public function login() {
  
        $user = new User('jonhSmith@example.com', 'haslo');

        if(!$this->ispost()) {
            return $this->render('start');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if (($user->getEmail() !== $email) && ($user->getPassword() !== $password)) {
            return $this->render('start', ['message' => ['Wrong password or email']]);
        }

        //check if user is admin run admin panel

        return $this->render('dashboard');
   }

   private function paneladmin() {
        return this->render('admin-panel');
   }
}

?>