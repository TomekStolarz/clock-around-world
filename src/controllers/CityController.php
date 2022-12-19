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
        $id_user = 2;//TODO: get stored user id from session
        $followedCities = $this->cityRepostiry->getFollowedCities($id_user);
        return $this->render('dashboard', ['followedCities' => $followedCities]);
   }

   public function citydetail() {
    $id_city = 1;
    $city = $this->cityRepostiry->getCity($id_city);
    $this->render('city-detail', ["city" => $city]);
}
}

?>