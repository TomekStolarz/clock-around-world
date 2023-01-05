<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController {
    private $userRepository;

    public function __construct() {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

   public function emailChange() {
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      $id_user = 1;

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
      $id_user = 1;

      if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            
            $changed = $this->userRepository->setNewPassword($decoded['password'], $id_user);
            http_response_code(200);
      }
   }

}

?>



