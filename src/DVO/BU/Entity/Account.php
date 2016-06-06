<?php

namespace BU\Entity;

use \MongoDB\BSON\Persistable;

/**
 * Account class
 *
 * @package default
 * @author
 **/
final class Account implements \MongoDB\BSON\Persistable
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
            '_id'      => '',
            'id'       => null,
            'email'    => null,
            'username' => null,
            'password' => null,
            'vcode'    => null,
            'verified' => false
        ];

        if (true === is_array($data)) {
            foreach ($data as $key => $value) {
                if (false === array_key_exists($key, $this->data)) {
                    throw new \Exception('Key ' . $key . ' does not exist in ' . get_called_class());
                }

                if ('password' === $key) {
                    $value = password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
                }

                $this->data[$key] = $value;
            }
        }
    }

    public function bsonSerialize()
    {
        foreach ($this->data as $key => $val) {
            $tmp[$key] = $val;
        }

        unset($tmp['_id']);

        return $tmp;
    }

    public function bsonUnserialize(array $data)
    {
        $this->set_id($data['_id']);
        $this->setId($data['id']);
        $this->setEmail($data['email']);
        $this->setUsername($data['username']);
        $this->setPassword($data['password']);
        $this->setVcode($data['vcode']);
    }


    /**
     * Return json data of object.
     *
     * @return string
     * @author
     **/
    public function json(): string
    {
        $tmp = $this->data;
        unset($tmp['_id']);

        return json_encode($tmp);
    }

    /**
     * SetId
     *
     * @return void
     * @author
     **/
    public function set_id($id)
    {
        $this->data['_id'] = $id;
    }

    /**
     * SetId
     *
     * @return void
     * @author
     **/
    public function setId(int $id)
    {
        $this->data['id'] = $id;
    }

    /**
     * Set Email
     *
     * @return void
     * @author
     **/
    public function setEmail(string $email)
    {
        $this->data['email'] = $email;
    }

    /**
     * Set Username
     *
     * @return void
     * @author
     **/
    public function setUsername(string $username)
    {
        $this->data['username'] = $username;
    }

    /**
     * Set password
     *
     * @return void
     * @author
     **/
    public function setPassword(string $password)
    {
        $this->data['password'] = $password;
    }


    /**
     * Set Vcode
     *
     * @return void
     * @author
     **/
    public function setVcode(string $vcode)
    {
        $this->data['vcode'] = $vcode;
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
     * get email
     *
     * @return int
     * @author
     **/
    public function getEmail(): string
    {
        return $this->data['email'];
    }

    /**
     * get username
     *
     * @return int
     * @author
     **/
    public function getUsername(): string
    {
        return $this->data['username'];
    }

    /**
     * get password
     *
     * @return int
     * @author
     **/
    public function getPassword(): string
    {
        return $this->data['password'];
    }

    /**
     * get vcode
     *
     * @return int
     * @author
     **/
    public function getVcode(): string
    {
        return $this->data['vcode'];
    }
} // END final class Account
