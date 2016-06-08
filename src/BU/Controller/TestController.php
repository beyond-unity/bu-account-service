<?php

namespace BU\Controller;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use BU\Entity\Account\AccountFactory;
use BU\Helper\AlphaRand;
use PhpAmqpLib\Connection\AMQPConnection;
use GuzzleHttp\Client;

use Firebase\JWT\JWT;

final class TestController
{

    public function rpcAction(Request $request, Response $response, $args): Response
    {
        $rpc = new \DVO\SlimRabbitRest\RpcClient($this->amqp);
        $resp = $rpc->get('/');
        $response->getBody()->write($resp);
        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Handles the HTTP GET.
     *
     * @param Request     $request The request.
     * @param Application $app     The app.
     *
     */
    public function restAction(Request $request, Response $response, $args): Response
    {

        $response = $this->guzzle->get(
            $this->settings['account.service.rest']['url'] . '',
            ['query' => []]
        );

        return $response;

    }
}
