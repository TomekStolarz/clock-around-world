<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $email): ?User {
        $stat = $this->database->connect()->prepare(
            'SELECT * FROM public.users WHERE login = :email'
        );
        $stat->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->execute();

        $user = $stat->fetch(PDO::FETCH_ASSOC);

        if($user == false) {
            return null;
        }

        return new User(
            $user['login'],
            $user['password'],
            $user['role']
        );
    }
}


?>