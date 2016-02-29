<?php

namespace BU\Entity\Account;

use BU\Db;

/**
 * AccountGateway
 *
 * @package default
 * @author
 **/
class AccountGateway
{
    protected $db;

    /**
     * Construct based on the DB
     *
     * @return void
     */
    public function __construct()
    {
        //$this->db = $db;
    }

    /**
     * Get the products
     *
     * @return array
     */
    public function getAccounts(array $search = []): array
    {
        $accounts = $this->db->find('accounts', $search);
        return $accounts;
    }

    public function createAccount(Account $account)
    {
        $this->db->insert($account->json());
    }

    public function updateAccount($id, Account $account)
    {
        $this->db->update($id, $account->json());
    }
}
