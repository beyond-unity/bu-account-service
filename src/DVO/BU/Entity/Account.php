<?php

namespace BU\Entity;

/**
 * Account class
 *
 * @package default
 * @author
 **/
final class Account
{
    protected $data;

    /**
     * Constructor
     *
     * @return void
     * @author
     **/
    public function __construct($data = [])
    {
        $this->data = [
            'id'    => null,
            'email' => null,
            'name'  => null
        ];

        if (true === is_array($data)) {
            foreach ($data as $key => $value) {
                if (false === array_key_exists($key, $this->data)) {
                    throw new \Exception('Key ' . $key . ' does not exist in ' . get_called_class());
                }
                $this->data[$key] = $value;
            }
        }
    }


    /**
     * Return json data of object.
     *
     * @return string
     * @author
     **/
    public function json(): string
    {
        return json_encode($this->data);
    }

    /**
     * SetId
     *
     * @return void
     * @author
     **/
    public function setId(int $id)
    {
        throw new \Exception('Cannot set the ID!');
    }

    /**
     * SetName
     *
     * @return void
     * @author
     **/
    public function setName(string $name)
    {
        $this->data['name'] = $name;
    }

    /**
     * SetEmail
     *
     * @return void
     * @author
     **/
    public function setEmail(string $email)
    {
        $this->data['email'] = $email;
    }

    /**
     * getId
     *
     * @return int
     * @author
     **/
    public function getId(): int
    {
        return $this->data['id'];
    }

    /**
     * getName
     *
     * @return int
     * @author
     **/
    public function getName(): string
    {
        return $this->data['name'];
    }

    /**
     * getEmail
     *
     * @return int
     * @author
     **/
    public function getEmail(): string
    {
        return $this->data['email'];
    }
} // END final class Account
