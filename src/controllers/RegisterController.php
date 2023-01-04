<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class RegisterController extends AppController {
    
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

   public function register() {

        if(!$this->ispost()) {
            return $this->render('register');
        }
        
        $email = $_POST['email'];
        $login = $_POST['login'];
        $password = $_POST['password'];

        $message = $this->userRepository->canRegisterUser($login, $email);
        if(gettype($message) == "array") {
            return $this->render('register', ['messages' => $message]);
        }

        $user = new User($login, $password, 2, $email);
        $this->userRepository->registerUser($user);

        return $this->render('login');
   }

}

?>