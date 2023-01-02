<?php 

require_once 'AppController.php';
require_once __DIR__.'/../models/City.php';
require_once __DIR__ . '/../repository/CityRepository.php';

class CityController extends AppController
{
    private $cityRepostiry;

    public function __construct() {
        parent::__construct();
        $this->cityRepostiry = new CityRepository();
    }

   public function dashboard() {
        return $this->render('dashboard');
   }

   public function citydetail() {
    $id_city = 2;
    $city = $this->cityRepostiry->getCity($id_city);
    if($city) {
        $this->render('city-detail', ["city" => $city]);
    }
   }

   public function followedCity() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if($contentType === "application/json") {
            $content = trim(file_get_contents("php::input"));
            $decoded = json . decode($content, true);

            header("Content-type: application/json");
            http_response_code(200);

            echo json_encode($this->cityRepostiry->getFollowedCities($decoded['id']));
        }
   }
}

?>