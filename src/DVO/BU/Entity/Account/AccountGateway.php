<?php

namespace BU\Entity\Account;

use BU\Db;
use \MongoDB\Model\BSONDocument;

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
    public function __construct($db)
    {
        $this->db = $db->selectCollection('accounts');
    }

    /**
     * Get the account
     *
     * @return array
     */
    public function getAccount(array $search = []): array
    {
        $account = $this->db->findOne(
            $search,
            ['typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']]
        );
        if (true === empty($account)) {
            return [];
        }

        return [$account];
    }

    public function insertAccount($account)
    {
        $current = $this->db->findOne(
            [],
            ["sort" => ["id" => -1], 'typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']]
        );
        $account->setId(++$current['id']);
        $result = $this->db->insertOne($account->bsonSerialize());

        return $result;
    }

    public function updateAccount($account)
    {
        $this->db->replaceOne(['id' => $account->getid()], $account->bsonSerialize());
    }
}
