<?php 

require_once __DIR__ .'/../models/History.php';
require_once __DIR__ .'/../models/User.php';

class UserHistory{

    private $user;

    private $history;

    public function __construct(User $user, array $history) {
        $this->user = $user;
        $this->history = $history;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function getHistory(): array {
        return $this->history;
    }

    public function jsonSerialize()
    {
        return array(
             'history' => $this->getHistory(),
             'user' => $this->getUser()->jsonSerialize()
        );
    }
}

?>