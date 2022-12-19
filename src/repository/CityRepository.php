<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/City.php';

class CityRepository extends Repository {

    public function getCity(int $id_city): ?City {
        $stat = $this->database->connect()->prepare(
            'SELECT c.city AS city, c.country as country, t.timezone as timezone, c.latitude as latitude, c.longitude as longitude
             FROM public.cities AS c
            INNER JOIN public.timezones AS t on c.id_timezone = t.id_timezone 
            WHERE id_city = :id_city'
        );
        $stat->bindParam(':id_city', $id_city, PDO::PARAM_INT);
        $stat->execute();

        $city = $stat->fetch(PDO::FETCH_ASSOC);

        if($city == false) {
            return null;
        }

        return new City(
            $city['city'],
            $city['country'],
            $city['timezone'],
            $city['latitude'],
            $city['longitude']
        );
    }

    public function getFollowedCities(int $id_user): array
    {
        $followedCities = [];
        $stat = $this->database->connect()->prepare(
            'SELECT c.city AS city, c.country as country, t.timezone as timezone, c.latitude as latitude, c.longitude as longitude
             FROM public.cities AS c 
             INNER JOIN public.followed_cities AS fc ON fc.id_city = c.id_city
             INNER JOIN public.users AS u ON u.id_user = fc.id_user
             INNER JOIN public.timezones AS t on c.id_timezone = t.id_timezone 
            WHERE fc.id_user = :id_user'
        );
        $stat->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stat->execute();

        $cities = $stat->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cities as $city) {
            $followedCities[] = new City(
                $city['city'],
                $city['country'],
                $city['timezone'],
                $city['latitude'],
                $city['longitude']
            );
        }

        return $followedCities;
    }
}


?>