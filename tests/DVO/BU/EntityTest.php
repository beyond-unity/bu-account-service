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
        $this->assertEquals(true, password_verify('asdfasdf', $obj->getPassword()));
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

        // can't compare json string due to password_hash (should mock it really..)
        $this->assertEquals('braintopmark', json_decode($obj->json(), true)['username']);
        $this->assertEquals('bobby@dvomedia.net', json_decode($obj->json(), true)['email']);
        $this->assertEquals('123123', json_decode($obj->json(), true)['vcode']);
        $this->assertEquals(true, $obj->passwordValid('asdfasdf'));
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

        $this->assertEquals('braintopmark', $obj->bsonSerialize()['username']);
        $this->assertEquals('bobby@dvomedia.net', $obj->bsonSerialize()['email']);
        $this->assertEquals('123123', $obj->bsonSerialize()['vcode']);
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
