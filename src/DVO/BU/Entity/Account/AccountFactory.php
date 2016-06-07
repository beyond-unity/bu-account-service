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
    public function create($data = [])
    {
        return new \BU\Entity\Account($data);
    }

    /**
     * Gets the account
     *
     * @param  array $search Search parameters
     * @return array
     */
    public function getAccount(array $search = []): \BU\Entity\Account
    {
        if (true === empty($search)) {
            $account = $this->create();
        } else {
            $account = $this->gateway->getAccount($search);
        }

        if (true === empty($account)) {
            throw new \Exception('Cannot find account');
        }

        $naccount = $this->create();
        $naccount->bsonUnserialize($account[0]);

        return $naccount;
    }
} // END final class AccountFactory
