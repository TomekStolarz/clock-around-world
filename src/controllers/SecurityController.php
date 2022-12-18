<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SecurityController extends AppController {
    
   public function login() {
        
        $userRepository = new UserRepository();

        if(!$this->ispost()) {
            return $this->render('login');
        }
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['User not exist']]);
        }

        if (($user->getEmail() !== $email) || ($user->getPassword() !== $password)) {
            return $this->render('login', ['messages' => ['Wrong password or email']]);
        }

        //check if user is admin run admin panel

        return $this->render('dashboard');
   }

   private function paneladmin() {
        return this->render('admin-panel');
   }
}

?>