<?php


namespace App\Data\User;


class UserService
{

    public function passwordEncode(string $password)
    {
        return $this->passwordHash($password);
    }

    public function passwordVerify(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }

    protected function passwordHash(string $encodedString)
    {
        return password_hash($encodedString, PASSWORD_DEFAULT);
    }
}