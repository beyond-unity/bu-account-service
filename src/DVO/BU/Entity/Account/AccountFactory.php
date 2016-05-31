<?php

namespace BU\Entity\Account;

/**
 * AccountFactory
 *
 * @package default
 * @author
 **/
class AccountFactory
{
    /**
     * AccountGateway
     *
     * @var AccountGateway
     **/
    protected $gateway;

    /**
     * AccountGateway
     *
     * @return void
     * @author
     **/
    public function __construct(AccountGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * get the gateway
     *
     * @return AccountGateway
     * @author
     **/
    public function getGateway(): AccountGateway
    {
        return $this->gateway;
    }

    /**
     * Create Account
     *
     * @return Account
     * @author
     **/
    public function create($data = []): Account
    {
        return new \BU\Entity\Account($data);
    }

    /**
     * Gets the account
     *
     * @param  array $search Search parameters
     * @return array
     */
    public function getAccount(array $search = []): Account
    {
        if (true === empty($search)) {
            $account = $this->create();
        } else {
            $account = $this->gateway->getAccount($search);
        }

        if (true === empty($celeb)) {
            throw new \Exception('Cannot find account');
        }

        $account = array_map(function ($a) {
            $s = $this->create((array) $a);

            return $s;
        }, $account);

        return $account[0];
    }
} // END final class AccountFactory
