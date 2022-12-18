<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $login): ?User {
        $stat = $this->database->connect()->prepare(
            'SELECT u.login as login, u.password as password, r.role as role, u.id_user as id_user
             FROM public.users as u INNER JOIN public.r as roles ON r.id_role = u.id_role 
             WHERE u.login = :email or u.email = :email;
            '
        );
        $stat->bindParam(':email', $login, PDO::PARAM_STR);
        $stat->execute();

        $user = $stat->fetch(PDO::FETCH_ASSOC);

        if($user == false) {
            return null;
        }

        return new User(
            $user['login'],
            $user['password'],
            $user['role'],
            $user['id_user']
        );
    }
}


?>