<?php


namespace App\Data\User;

use App\Db\Db;
use Exception;

class UserRepository
{

    /**
     * @param int $id
     * @return UserModel|null
     * @throws Exception
     */
    public function getById(int $id): ?UserModel
    {
        $query = "SELECT u.* FROM users u WHERE u.id = $id";
        $dataArray = Db::fetchRow($query);

        if (empty($dataArray)) {
            return null;
        }


        return $this->fromArray($dataArray);
    }

    /**
     * @param string $email
     * @param string $password
     * @return UserModel|null
     * @throws Exception
     */
    public function getByEmail(string $email): ?UserModel
    {
        $query = "SELECT u.* FROM users u WHERE u.email = '$email'";
        $dataArray = Db::fetchRow($query);

        if (empty($dataArray)) {
            return null;
        }

        return $this->fromArray($dataArray);
    }

    public function save(UserModel $user): UserModel
    {
        $id = $user->getId();
        $arrayData = $this->toArray($user);

        if ($id) {
            Db::update('users', $arrayData, "id = $id");

            return $user;
        }

        $id = Db::insert('users', $arrayData);
        $user->setId($id);

        return $user;
    }


    public function toArray(UserModel $user)
    {
        $data = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ];

        return $data;
    }

    /**
     * @param array $data
     * @return UserModel
     * @throws Exception
     */
    public function fromArray(array $data): UserModel
    {
        $id = $data['id'];

        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if (is_null($name)) {
            throw new Exception('Имя пользователя для инициализации модели обязательно');
        }

        if (is_null($email)) {
            throw new Exception('Емейл пользователя для инициализации модели обязательно');
        }

        if (is_null($password)) {
            throw new Exception('Пароль пользователя для инициализации модели обязательно');
        }


        $user = new UserModel($name, $email, $password);

        $user
            ->setId($id);

        return $user;
    }

}