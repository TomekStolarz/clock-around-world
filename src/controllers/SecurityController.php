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

        if (($user->getEmail() !== $email) || (!password_verify($password, $user->getPassword()))) {
            return $this->render('login', ['messages' => ['Wrong password or email']]);
        }

        $this->historyRepository->addUserHistory($user->getId(), "login");
        

        $user_cookie = 'user-id';
        $cookie_value = $user->getId();
        setcookie($user_cookie, $cookie_value, time() + (60 * 30), "/");

        $user_cookie = 'user-email';
        $cookie_value = $user->getEmail();
        setcookie($user_cookie, $cookie_value, time() + (60 * 30), "/");

        if ($user->getRole() === "admin") {
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/adminpanel");
        } 

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
   }

   public function logout() {
        $this->historyRepository->addUserHistory($_COOKIE['user-id'], "logout");

        setcookie('user-id', $_COOKIE['user-id'], time() - 10, "/");
        setcookie('user-email', $_COOKIE['user-email'], time() - 10, "/");
        
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
   }

   private function paneladmin() {
        return $this->render('admin-panel');
   }
}

?>