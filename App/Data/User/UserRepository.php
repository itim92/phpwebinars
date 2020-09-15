<?php


namespace App\Data\User;

use App\Db\Db;

class UserRepository
{
    public function save(UserModel $user): UserModel
    {
        $id = $user->getId();
        $arrayData = $this->productToArray($user);

        if ($id) {
            Db::update('users', $arrayData, "id = $id");

            return $user;
        }

        $id = Db::insert('users', $arrayData);
        $user->setId($id);

        return $user;
    }


    public function productToArray(UserModel $user)
    {
        $data = [
            'name'        => $user->getName(),
            'email'     => $user->getEmail(),
            'password'      => $user->getPassword(),
        ];

        return $data;
    }
}