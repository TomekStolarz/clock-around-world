<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $login): ?User {
        $stat = $this->database->connect()->prepare(
            'SELECT u.login as login, u.password as password, r.role as role, u.id_user as id_user, u.email as email
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
            $user['email'],
            $user['id_user']
        );
    }

    public function canRegisterUser(string $login, string $email): ?string {
        $stat = $this->database->connect()->prepare(
            'SELECT *
             FROM public.users as u INNER JOIN public.r as roles ON r.id_role = u.id_role 
             WHERE u.login = :login;
            '
        );
        $statTwo = $this->database->connect()->prepare(
            'SELECT *
             FROM public.users as u INNER JOIN public.r as roles ON r.id_role = u.id_role 
             WHERE u.email = :email;
            '
        );
        $stat->bindParam(':login', $login, PDO::PARAM_STR);
        $statTwo->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->execute();
        $statTwo->execute();
        

        $userLoginExist = $stat->fetch(PDO::FETCH_ASSOC);
        $userEmailExist = $statTwo->fetch(PDO::FETCH_ASSOC);

        $message = [];
        if($userEmailExist) {
            $message[] = "User with this email exist";
        }

        if($userLoginExist) {
            $message[] = "User with this login exist";
        }

        return ($userEmailExist == false && $userLoginExist == false) || $message;
    }

    public function registerUser(User $user) {
        $stat = $this->database->connect()->prepare(
            'INSERT INTO users(login, email, password, id_role) VALUES (?, ?, ?, ?);
            '
        );
        $stat->execute(
            $user->getLogin(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole()
        );
    }
}


?>