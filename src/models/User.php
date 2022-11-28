<?php

class User
{

    private $id;
    private $email;
    private $password;
    private $name;
    private $surname;

    private function __construct()
    {
    }

    public static function makeUserWithId($id, $email, $password, $name, $surname): User
    {
        $user = new User();
        $user->setId($id);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setName($name);
        $user->setSurname($surname);

        return $user;
    }

    public static function makeUserWithoutId($email, $password, $name, $surname): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setName($name);
        $user->setSurname($surname);

        return $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }




}