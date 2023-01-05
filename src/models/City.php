<?php 

class City{
    private $city;
    private $country;
    private $timezone;
    private $latitude;
    private $longitude;

    private $id;

    public function __construct(string $city, string $country, string $timezone, string $latitude, string $longitude, int $city_id) {
        $this->city = $city;
        $this->country = $country;
        $this->timezone = $timezone;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->id = $city_id;
    }

    public function getCity(): string {
        return $this->city;
    }

    public function getCountry(): string {
        return $this->country;
    }

    public function getTimezone(): string {
        return $this->timezone;
    }

    public function getLatitude(): string {
        return $this->latitude;
    }

    public function getLongitude(): string {
        return $this->longitude;
    }

    public function getId(): int {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return array(
             'city' => $this->getCity(),
             'country' => $this->getCountry(),
             'timezone' => $this->getTimezone(),
             'latitude' => $this->getLatitude(),
             'longitude' => $this->getLongitude(),
             'id' => $this->getId()
        );
    }

}

?>