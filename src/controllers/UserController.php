<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/UserHistory.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/HistoryRepository.php';

class UserController extends AppController {
    private $userRepository;
    private $historyRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->historyRepository = new HistoryRepository();
    }

   public function emailChange() {
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      $id_user = $_COOKIE["user-id"];

      if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            
            $changed = $this->userRepository->emailChange($decoded['email'], $id_user);
            $response = array();
            if (is_bool($changed)) {
               http_response_code(200);
            }
            else {
               http_response_code(409);
               $response["message"] = $changed;
            }
            
            echo json_encode($response);
      }
   }

   public function passwordChange() {
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      $id_user = $_COOKIE["user-id"];

      if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            $this->userRepository->setNewPassword(password_hash($decoded['password'], PASSWORD_BCRYPT), $id_user);
            http_response_code(200);
      }
   }

   public function adminpanel() {
      $users = $this->userRepository->getUsers();
      return $this->render('admin-panel', ["users" => $users]);
  }

  public function userDelete() {
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

      if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            
            $this->userRepository->deleteUser($decoded['id_user']);
            http_response_code(200);
      }
  }

  public function userHistory() {
   $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

   if ($contentType === "application/json") {
         $content = trim(file_get_contents("php://input"));
         $decoded = json_decode($content, true);
         
         http_response_code(200);
         $history = $this->historyRepository->getUserHistory($decoded['id_user']);
         $user = $this->userRepository->getUserById($decoded['id_user']);
         $response = new UserHistory($user, $history);
         echo json_encode($response->jsonSerialize());
   }
}
}

?>