<?php 

class City{
    private $city;
    private $country;
    private $timezone;
    private $latitude;
    private $longitude;

    public function __construct(string $city, string $country, string $timezone, string $latitude, string $longitude) {
        $this->city = $city;
        $this->country = $country;
        $this->timezone = $timezone;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getCity() {
        return $this->city;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getTimezone() {
        return $this->timezone;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }
}

?>