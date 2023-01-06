<?php 

class History{

    private $action;

    private $time;

    public function __construct(string $action, string $time) {
        $this->action = $action;
        $this->time = $time;
    }

    public function getTime(): string{
        return $this->time;
    }

    public function getAction(): string{
        return $this->action;
    }

    public function jsonSerialize()
    {
        return array(
             'action' => $this->getAction(),
             'time' => $this->getTime()
        );
    }
}

?>