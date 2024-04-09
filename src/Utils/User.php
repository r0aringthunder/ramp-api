<?php
namespace R0aringthunder\RampApi\Utils;

class User
{
    protected $userData;

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function getAllUserData()
    {
        return $this->userData;
    }
}
