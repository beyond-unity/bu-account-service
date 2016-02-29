<?php

class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testEntitySite()
    {
        $obj = new \BU\Entity\Account;
        $this->assertInstanceOf('\BU\Entity\Account', $obj);
    }

    public function testEntitySetters()
    {
        $obj = new \BU\Entity\Account;
        $obj->setName('Bobby');
        $obj->setEmail('bobby@dvomedia.net');

        $this->assertEquals('Bobby', $obj->getName());
        $this->assertEquals('bobby@dvomedia.net', $obj->getEmail());
    }

    /**
     * @group entityTests
     */
    public function testHydration()
    {
        $obj = new \BU\Entity\Account([
        	'id'    => 1,
        	'name'  => 'Bobby',
        	'email' => 'bobby@dvomedia.net'
        ]);
        $this->assertEquals('1', $obj->getId());
        $this->assertEquals('Bobby', $obj->getName());
        $this->assertEquals('bobby@dvomedia.net', $obj->getEmail());
    }

    /**
     * @group entityTests
     */
    public function testJson()
    {
        $obj = new \BU\Entity\Account([
        	'id'    => 1,
        	'name'  => 'Bobby',
        	'email' => 'bobby@dvomedia.net'
        ]);
        
        $this->assertEquals('{"id":1,"email":"bobby@dvomedia.net","name":"Bobby"}', $obj->json());
    }
}
