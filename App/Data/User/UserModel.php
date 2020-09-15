<?php


namespace App\Data\User;


class UserModel
{
    /**
     * @var int
     */
    private $id = 0;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param int $id
     * @return UserModel
     */
    public function setId(int $id): UserModel
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @param string $name
     * @return UserModel
     */
    public function setName(string $name): UserModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $password
     * @return UserModel
     */
    public function setPassword(string $password): UserModel
    {
        $this->password = $password;
        return $this;
    }



}