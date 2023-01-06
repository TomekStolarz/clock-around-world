<?php

require_once 'Repository.php';
require_once __DIR__ .'/../models/History.php';

class HistoryRepository extends Repository {

     public function getUserHistory(int $userId) {
        $stat = $this->database->connect()->prepare(
            'SELECT action, time
             FROM public.sessions 
             WHERE id_user = :id_user;
            '
        );
        $stat->bindParam(":id_user", $userId, PDO::PARAM_INT);
        $stat->execute();

        $history = $stat->fetchAll(PDO::FETCH_ASSOC);

        return $history;
     }

     public function addUserHistory(int $userId, string $action) {
        $stat = $this->database->connect()->prepare(
            'INSERT INTO public session(action, time) VALUES (?, ?)'
        );
        $stat->execute([
            $userId,
            $action
        ]);
     }
}


?>