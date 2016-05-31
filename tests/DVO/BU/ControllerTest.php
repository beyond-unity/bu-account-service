<?php

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testControllerConstructor()
    {
        $ml        = $this->getMock('\Monolog\Logger', array(), array(), '', false);
        $maf       = $this->getMock('\BU\Entity\Account\AccountFactory', array(), array(), '', false);
        $mamqp     = $this->getMock('\PhpAmqpLib\Connection\AMQPConnection', array(), array(), '', false);
        $mguzzle   = $this->getMock('\Guzzlehttp\Client', array(), array(), '', false);
        $msettings = array();

        $obj = new \BU\Controller\AccountController($ml, $maf, $mamqp, $mguzzle, $msettings);
        $this->assertInstanceOf('\BU\Controller\AccountController', $obj);
    }

}
