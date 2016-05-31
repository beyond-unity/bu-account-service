<?php

class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testEntityAccount()
    {
        $obj = new \BU\Entity\Account;
        $this->assertInstanceOf('\BU\Entity\Account', $obj);
    }

    /**
     * @expectedException     Exception
     */
    public function testConstructorException()
    {
        $obj = new \BU\Entity\Account(['country' => 'uk']);
    }

    public function testEntitySetters()
    {
        $obj = new \BU\Entity\Account;
        $obj->setUsername('briantopmark');
        $obj->setEmail('bobby@dvomedia.net');
        $obj->setPassword('asdfasdfasdf');
        $obj->setVcode('123123');

        $this->assertEquals('briantopmark', $obj->getUsername());
        $this->assertEquals('bobby@dvomedia.net', $obj->getEmail());
        $this->assertEquals('asdfasdfasdf', $obj->getPassword());
        $this->assertEquals('123123', $obj->getVcode());
    }

    /**
     * @group entityTests
     */
    public function testHydration()
    {
        $obj = new \BU\Entity\Account([
        	'id'    => 1,
        	'username'  => 'briantopmark',
        	'email' => 'bobby@dvomedia.net',
            'password' => 'asdfasdf',
            'vcode' => '123123',
        ]);
        $this->assertEquals('1', $obj->getId());
        $this->assertEquals('briantopmark', $obj->getUsername());
        $this->assertEquals('bobby@dvomedia.net', $obj->getEmail());
        $this->assertEquals('asdfasdf', $obj->getPassword());
        $this->assertEquals('123123', $obj->getVcode());
    }

    /**
     * @group entityTests
     */
    public function testJson()
    {
        $obj = new \BU\Entity\Account([
        	'id'    => 1,
        	'username'  => 'braintopmark',
        	'email' => 'bobby@dvomedia.net',
            'password' => 'asdfasdf',
            'vcode' => '123123',
        ]);

        $this->assertEquals('{"id":1,"email":"bobby@dvomedia.net","username":"braintopmark","password":"asdfasdf","vcode":"123123"}', $obj->json());
    }

    public function testBsonSerialize()
    {
        $obj = new \BU\Entity\Account([
            'id'    => 1,
            'username'  => 'braintopmark',
            'email' => 'bobby@dvomedia.net',
            'password' => 'asdfasdf',
            'vcode' => '123123'
        ]);

        $this->assertEquals([
            'id'    => 1,
            'username'  => 'braintopmark',
            'email' => 'bobby@dvomedia.net',
            'password' => 'asdfasdf',
            'vcode' => '123123'
            ],
            $obj->bsonSerialize()
        );
    }

    public function testBsonUnserialize()
    {
        $data = [
            '_id'   => 'Ikadfia90r23e2',
            'id'    => 1,
            'username'  => 'briantopmark',
            'email' => 'bobby@dvomedia.net',
            'password' => 'asdfasdf',
            'vcode' => '123123'
        ];

        $obj = new \BU\Entity\Account();
        $obj->bsonUnserialize($data);

        $this->assertEquals('1', $obj->getId());
        $this->assertEquals('briantopmark', $obj->getUsername());
        $this->assertEquals('bobby@dvomedia.net', $obj->getEmail());
        $this->assertEquals('asdfasdf', $obj->getPassword());
        $this->assertEquals('123123', $obj->getVcode());
    }
}
