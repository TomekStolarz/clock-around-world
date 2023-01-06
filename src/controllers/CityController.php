<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/City.php';
require_once __DIR__ . '/../repository/CityRepository.php';

class CityController extends AppController
{
     private $cityRepostiry;

     public function __construct()
     {
          parent::__construct();
          $this->cityRepostiry = new CityRepository();
     }

     public function dashboard()
     {
          $id_user = $_COOKIE["user-id"];
          $followedCities = $this->cityRepostiry->getFollowedCities($id_user);
          return $this->render('dashboard', ["followedCities" => $followedCities]);
     }

     public function citydetail(string $id_city)
     {
          $id_city = intval($id_city);
          $city = $this->cityRepostiry->getCity($id_city);
          if ($city) {
               $this->render('city-detail', ["city" => $city]);
          }
     }


     public function follow(int $id_city)
     {
          $id_user = $_COOKIE["user-id"];
          $this->cityRepostiry->addFollowedCity($id_city, $id_user);
          http_response_code(200);
     }

     public function unfollow(int $id_city)
     {
          $id_user = $_COOKIE["user-id"];
          $this->cityRepostiry->removeFollowedCity($id_city, $id_user);
          http_response_code(200);
     }

     public function isFollowed()
     {
          $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
          $id_user = $_COOKIE["user-id"];

          if ($contentType === "application/json") {
               $content = trim(file_get_contents("php://input"));
               $decoded = json_decode($content, true);

               http_response_code(200);

               $followed = $this->cityRepostiry->isFollowed($decoded['id_city'], $id_user);
               $response = array('isFollowed' => $followed);
               echo json_encode($response);
          }
     }

     public function allCities()
     {
          $cities = $this->cityRepostiry->getCities();
          http_response_code(200);
          echo json_encode($cities);
     }

     public function searchCities()
     {
          $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

          if ($contentType === "application/json") {
               $content = trim(file_get_contents("php://input"));
               $decoded = json_decode($content, true);

               http_response_code(200);

               echo json_encode($this->cityRepostiry->getCitiesBySearch($decoded['search']));
          }
     }
}

?>