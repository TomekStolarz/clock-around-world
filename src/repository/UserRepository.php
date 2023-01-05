<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/User.php';

class UserRepository extends Repository {

    public function getUser(string $login): ?User {
        $stat = $this->database->connect()->prepare(
            'SELECT u.login as login, u.password as password, r.role as role, u.id_user as id_user, u.email as email
             FROM public.users as u INNER JOIN public.roles as r ON r.id_role = u.id_role 
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

    private function emailExist(string $email): string|bool {
        $stat = $this->database->connect()->prepare(
            'SELECT *
             FROM public.users as u
             WHERE u.email = :email;
            '
        );

        $stat->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->execute();
        $userEmailExist = $stat->fetch(PDO::FETCH_ASSOC);
        

        if($userEmailExist) {
            return "User with this email exist";
        }
        return false;
    }

    private function loginExist(string $login): string|bool {
        $stat = $this->database->connect()->prepare(
            'SELECT *
             FROM public.users as u
             WHERE u.login = :login;
            '
        );

        $stat->bindParam(':login', $login, PDO::PARAM_STR);
        $stat->execute();
        $userLoginExist = $stat->fetch(PDO::FETCH_ASSOC);

        if($userLoginExist) {
            return "User with this login exist";
        }
        return false;
    }

    public function canRegisterUser(string $login, string $email): array|bool {
        

        $userLoginExist = $this->loginExist($login);
        $userEmailExist = $this->emailExist($email);
        $message = [];
        if($userEmailExist != false) {
            $message[] = $userEmailExist;
        }

        if($userLoginExist != false) {
            $message[] = $userLoginExist;
        }
        return count($message) == 0 ? true : $message;
    }

    public function registerUser(User $user) {
        $stat = $this->database->connect()->prepare(
            'INSERT INTO users(login, email, password, id_role) VALUES (?, ?, ?, ?);
            '
        );
        $stat->execute([
            $user->getLogin(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRole()
        ]);
    }

    public function emailChange(string $email, int $id_user): string|bool{
        $userEmailExist = $this->emailExist($email);
        if ($userEmailExist != false) {
            return $userEmailExist;
        }

        $stat = $this->database->connect()->prepare(
            'UPDATE users SET email = :email WHERE id_user = :id_user;
            '
        );
        $stat->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stat->execute();

        return true;
    }

    public function setNewPassword(string $password, int $id_user): bool{
        $stat = $this->database->connect()->prepare(
            'UPDATE users SET password = :password WHERE id_user = :id_user;
            '
        );
        $stat->bindParam(':password', $password, PDO::PARAM_STR);
        $stat->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stat->execute();

        return true;
    }
}


?>