<?php

namespace fvy\Korus\Models;

class User
{
    /**
     * @var string $username User's Name
     */
    private $username;

    /**
     * @var string $email User's Email
     */
    private $email;

    /**
     * @var string $info User's info field
     */
    private $info;

    public static function fromState(array $state): User
    {
        // validate state before accessing keys!

        return new self(
            $state['username'],
            $state['email']
        );
    }

    public function __construct(string $username, string $email)
    {
        // validate parameters before setting them!

        $this->username = $username;
        $this->email = $email;
        $this->info = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
}