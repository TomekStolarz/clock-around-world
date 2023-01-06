<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/HistoryRepository.php';

class SecurityController extends AppController {
   
    private $userRepository;
    private $historyRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->historyRepository = new HistoryRepository();
    }

   public function login() {

        if(!$this->ispost()) {
            return $this->render('login');
        }
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if(!$user) {
            return $this->render('login', ['messages' => ['User not exist']]);
        }

        if (($user->getEmail() !== $email) || ($user->getPassword() !== $password)) {
            return $this->render('login', ['messages' => ['Wrong password or email']]);
        }

        $this->historyRepository->addUserHistory($user->getId(), "login");

        //check if user is admin run admin panel

        return $this->render('dashboard');
   }

   public function logout() {
        $user_id = 1;
        $this->historyRepository->addUserHistory($user_id, "logout");
   }

   private function paneladmin() {
        return $this->render('admin-panel');
   }
}

?>