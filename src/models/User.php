<?php 

class User{
    private $email;
    private $password;

    private $role;

    public function __construct(string $email, string $password, string $role) {
        $this->email = $email;
        $this->password = $password;
        $this->$role = $role;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
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
	
	public function setRole($role): self {
		$this->role = $role;
		return $this;
	}
}

?>