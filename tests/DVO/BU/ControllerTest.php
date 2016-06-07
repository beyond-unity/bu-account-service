<?php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testControllerConstructor()
    {
        $ml        = $this->createMock('\Monolog\Logger');
        $maf       = $this->createMock('\BU\Entity\Account\AccountFactory');
        $mguzzle   = $this->createMock('\GuzzleHttp\Client');
        $msettings = array();

        $obj = new \BU\Controller\AccountController($ml, $maf, $mguzzle, $msettings);
        $this->assertInstanceOf('\BU\Controller\AccountController', $obj);
    }

    public function testIndexAction()
    {
        $ml        = $this->createMock('\Monolog\Logger');
        $maf       = $this->createMock('\BU\Entity\Account\AccountFactory');
        $mguzzle   = $this->createMock('\GuzzleHttp\Client');
        $msettings = array();

        $uri = Uri::createFromString('/');
        $headers = new Headers();
        $cookies = [];
        $serverParams = [];
        $body = new Body(fopen('php://temp', 'r+'));
        $req = new Request('GET', $uri, $headers, $cookies, $serverParams, $body);
        $res = new Response();

        $obj = new \BU\Controller\AccountController($ml, $maf, $mguzzle, $msettings);
        $response = $obj->indexAction($req, $res, []);
        $this->assertEquals(401, $response->getStatusCode());
        $this->assertEquals('{"error":"You must provide a method","token":null}', $response->getBody());

    }

    public function testCreateAccountErrorsAction()
    {
        $ml        = $this->createMock('\Monolog\Logger');
        $maf       = $this->createMock('\BU\Entity\Account\AccountFactory');
        $mguzzle   = $this->createMock('\GuzzleHttp\Client');
        $msettings = array();

        $uri = Uri::createFromString('/');
        $headers = new Headers();
        $cookies = [];
        $serverParams = [];
        $body = new Body(fopen('php://temp', 'r+'));
        $req = new Request('POST', $uri, $headers, $cookies, $serverParams, $body);
        $res = new Response();

        $obj = new \BU\Controller\AccountController($ml, $maf, $mguzzle, $msettings);
        $response = $obj->createAccountAction($req, $res, []);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(
        	'{"errors":["You must supply a username","You must supply an email","You must supply a password"]}',
        	$response->getBody()->__toString());

    }

    public function testCreateAccountSuccessAction()
    {
        $ml        = $this->createMock('\Monolog\Logger');
        $mguzzle   = $this->createMock('\GuzzleHttp\Client');
        $msettings = array();

        $maf = $this->getMockBuilder('\BU\Entity\Account\AccountFactory')
    	            ->disableOriginalConstructor()
    	            ->setMethods(['getGateway'])
    	            ->getMock();

        $maf->expects($this->any())
            ->method('getGateway')
            ->will($this->returnValue($this->createMock('\BU\Entity\Account\AccountGateway')));

        $req = self::createFromEnvironment(\Slim\Http\Environment::mock([
            'REQUEST_METHOD'    => 'POST',
            'REQUEST_URI'       => '/createaccount',
            'QUERY_STRING'      => '',
            'CONTENT_TYPE'      => 'application/json',
        ]), '{
		    "email": "me@bobbyjason.co.uk",
		    "username": "bobbyjason4",
		    "password": "testing"
		}');
        $res = new Response();

        $obj = new \BU\Controller\AccountController($ml, $maf, $mguzzle, $msettings);
        $response = $obj->createAccountAction($req, $res, []);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('me@bobbyjason.co.uk',
        	json_decode($response->getBody()->__toString(), true)['email']);
    }

    public static function createFromEnvironment(\Slim\Http\Environment $environment, string $contents)
    {
        $method = $environment['REQUEST_METHOD'];
        $uri = \Slim\Http\Uri::createFromEnvironment($environment);
        $headers = \Slim\Http\Headers::createFromEnvironment($environment);
        $cookies = \Slim\Http\Cookies::parseHeader($headers->get('Cookie', []));
        $serverParams = $environment->all();

        // Seems the only way to stay PSR-7 compliant..?
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $contents);
        rewind($stream);
        $body = new \Slim\Http\Body($stream);

        $uploadedFiles = \Slim\Http\UploadedFile::createFromEnvironment($environment);

        $request = new \Slim\Http\Request($method, $uri, $headers, $cookies, $serverParams, $body, $uploadedFiles);

        if ($method === 'POST' &&
            in_array($request->getMediaType(), ['application/x-www-form-urlencoded', 'multipart/form-data'])
        ) {
            // parsed body must be $_POST
            $request = $request->withParsedBody($_POST);
        }

        return $request;
    }



}
