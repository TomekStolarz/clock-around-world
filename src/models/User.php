<?php 

class User{
    private $login;
    private $password;

    private $role;

    private $id;

    public function __construct(string $login, string $password, string $role, int $id) {
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
        $this->id = $id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin(string $login) {
        $this->login = $login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

	public function getRole() {
		return $this->role;
	}
	
	public function setRole($role) {
		$this->role = $role;
	}

    public function getId() {
        return $this->id;
    }
}

?>