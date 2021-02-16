<?php

class cLogin
{
    private $user;
    private $passw;

    public function __construct()
    {
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getPassw()
    {
        return $this->passw;
    }

    public function setPassw($passw)
    {
        $this->passw = $passw;
    }


}
?>