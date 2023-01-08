<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/City.php';

class CityRepository extends Repository {

    public function getCity(int $id_city): ?City {
        $stat = $this->database->connect()->prepare(
            'SELECT c.id_city as id_city, c.city AS city, c.country as country, t.timezone as timezone, c.latitude as latitude, c.longitude as longitude
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
            $city['longitude'],
            $city['id_city']
        );
    }

    public function getCities(): array {
        $cities = [];
        $stat = $this->database->connect()->prepare(
            'SELECT c.id_city as id_city, c.city AS city, c.country as country, t.timezone as timezone, c.latitude as latitude, c.longitude as longitude
             FROM public.cities AS c 
             INNER JOIN public.timezones AS t on c.id_timezone = t.id_timezone 
            '
        );
        $stat->execute();

        $_cities = $stat->fetchAll(PDO::FETCH_ASSOC);

        foreach ($_cities as $city) {
            $_city = new City(
                $city['city'],
                $city['country'],
                $city['timezone'],
                $city['latitude'],
                $city['longitude'],
                $city['id_city']
            );
            $cities[] = $_city->jsonSerialize();
        }
        return $cities;
    }

    public function getCitiesBySearch(string $searchTerm): array|null {
        $searchLower = '%' . strtolower($searchTerm) . '%';
        $searchTerm = strtolower($searchTerm);
        $stat = $this->database->connect()->prepare(
            'SELECT c.id_city as id_city, c.city AS city, c.country as country, t.timezone as timezone, c.latitude as latitude, c.longitude as longitude
             FROM public.cities AS c 
             INNER JOIN public.timezones AS t on c.id_timezone = t.id_timezone 
             WHERE LOWER(c.city) LIKE :search OR LOWER(c.country) = :searchCountry
             LIMIT 500;
            '
        );
        $stat->bindParam(':search', $searchLower, PDO::PARAM_STR);
        $stat->bindParam(':searchCountry', $searchTerm , PDO::PARAM_STR);
        $stat->execute();

        return  $stat->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFollowedCities(int $id_user): array
    {
        $followedCities = [];
        $stat = $this->database->connect()->prepare(
            'SELECT c.id_city as id_city, c.city AS city, c.country as country, t.timezone as timezone, c.latitude as latitude, c.longitude as longitude
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
                $city['longitude'],
                $city['id_city']
            );
        }

        return $followedCities;
    }

    public function addFollowedCity(int $id_city, int $id_user) {
        $stat = $this->database->connect()->prepare(
            'INSERT INTO public.followed_cities(id_user, id_city) VALUES (?, ?);
            '
        );
        $stat->execute([
            $id_user,
            $id_city,
        ]);
    }

    public function removeFollowedCity(int $id_city, int $id_user) {
        $stat = $this->database->connect()->prepare(
            'DELETE FROM public.followed_cities WHERE id_user = :id_user AND id_city = :id_city;
            '
        );
        $stat->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stat->bindParam(':id_city', $id_city, PDO::PARAM_INT);
        $stat->execute();
    }

    public function isFollowed(int $id_city, int $id_user) {
        $stat = $this->database->connect()->prepare(
            'SELECT * FROM followed_cities WHERE id_user = :id_user AND id_city = :id_city;
            '
        );
        $stat->bindParam(':id_city', $id_city, PDO::PARAM_INT);
        $stat->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stat->execute();

        $selected = $stat->fetch(PDO::FETCH_ASSOC);
        if ($selected == false)
            return false;
        return true; 
    }
}


?>