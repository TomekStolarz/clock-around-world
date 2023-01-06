<?php 

class User{
    private $login;
    private $password;

    private $role;

    private $id;

    private $email;

    public function __construct(string $login, string $password, string $role, string $email, int $id=null) {
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
        $this->id = $id;
        $this->email = $email;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function setLogin(string $login) {
        $this->login = $login;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

	public function getRole(): string {
		return $this->role;
	}
	
	public function setRole($role) {
		$this->role = $role;
	}

    public function getId(): int {
        return $this->id;
    }

    public function getEmail(): string {
		return $this->email;
	}
	
	public function setEmail($email) {
		$this->email = $email;
	}

    public function jsonSerialize()
    {
        return array(
             'login' => $this->getLogin(),
             'email' => $this->getEmail(),
             'id' => $this->getId()
        );
    }
}

?>