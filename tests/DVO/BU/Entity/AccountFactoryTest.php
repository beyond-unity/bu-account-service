<?php

class AccountFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
    	$mag = $this->createMock('\BU\Entity\Account\AccountGateway');
        $obj = new \BU\Entity\Account\AccountFactory($mag);
        $this->assertInstanceOf('\BU\Entity\Account\AccountFactory', $obj);
    }

    public function testCreate()
    {
    	$mag = $this->createMock('\BU\Entity\Account\AccountGateway');
        $obj = new \BU\Entity\Account\AccountFactory($mag);

        $account = $obj->create([
			'id'       => 1,
			'username' => 'briantopmark',
			'email'    => 'bobby@dvomedia.net',
			'password' => 'asdfasdf',
			'vcode'    => '123123',
        ]);

        $gateway = $obj->getGateway();
        $this->assertInstanceOf('\BU\Entity\Account\AccountGateway', $gateway);
        $this->assertEquals('1', $account->getId());
        $this->assertEquals('briantopmark', $account->getUsername());
        $this->assertEquals('bobby@dvomedia.net', $account->getEmail());
        $this->assertEquals(true, password_verify('asdfasdf', $account->getPassword()));
        $this->assertEquals('123123', $account->getVcode());
    }

    public function testGetAccount()
    {
    	$mag = $this->getMockBuilder('\BU\Entity\Account\AccountGateway')
    	            ->disableOriginalConstructor()
    	            ->setMethods(['getAccount'])
    	            ->getMock();

    	$mag->expects($this->any())
            ->method('getAccount')
            ->will($this->returnValue([
            	'_id' => 'test',
            	'id'  => 1,
            	'username' => 'bobbyjason',
            	'email'   => 'me@bobbyjason.co.uk',
            	'password' => 'asdfasdfasdfasdfadf',
            	'vcode' => 'asfasdfasdf',
            	'verified' => false
            ]));

        $obj = new \BU\Entity\Account\AccountFactory($mag);

        $account = $obj->getAccount(['username' => 'bobbyjason']);
        $this->assertInstanceOf('\BU\Entity\Account', $account);
    }

    /**
     * @expectedException Exception
     */
    public function testNotFound()
    {
    	$mag = $this->getMockBuilder('\BU\Entity\Account\AccountGateway')
    	            ->disableOriginalConstructor()
    	            ->setMethods(['getAccount'])
    	            ->getMock();

    	$mag->expects($this->any())
            ->method('getAccount')
            ->will($this->returnValue([]));

        $obj = new \BU\Entity\Account\AccountFactory($mag);

        $account = $obj->getAccount();
        $this->assertInstanceOf('\BU\Entity\Account', $account);

        $account = $obj->getAccount(['username' => 'bobbyjasonasd']);
        $this->assertInstanceOf('\BU\Entity\Account', $account);
    }
}
