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
} // END final class AccountFactory
