<?php
class Admin
{
    public $codeAdmin;
    public $login;
    public $password;

    function __construct($codeAdmin = null, $login = null, $password = null) {
        $this->codeAdmin = $codeAdmin;
        $this->login = $login;
        $this->password = $password;
    }

    public function loginUser($login, $password) {
        
        $validLogin = 'admin';
        $validPassword = 'motdepasse';

        if ($login === $validLogin && $password === $validPassword) {
            return true;
        } else {
            return false;
        }
    }
}
?>
