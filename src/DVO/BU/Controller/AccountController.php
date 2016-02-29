<?php

namespace BU\Controller;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use BU\Entity\Account\AccountFactory;
use PhpAmqpLib\Connection\AMQPConnection;
use GuzzleHttp\Client;

final class AccountController
{
    /**
     * View & Logger
     */
    protected $view;
    protected $logger;

    /**
     * Handles the HTTP GET.
     *
     * @param Twig            $view   The view ()
     * @param LoggerInterface $logger The app.
     *
     */
    public function __construct(
        LoggerInterface $logger,
        AccountFactory $af,
        AMQPConnection $amqp,
        Client $guzzleclient,
        $settings
    ) {
        $this->logger   = $logger;
        $this->af       = $af;
        $this->amqp     = $amqp;
        $this->guzzle   = $guzzleclient;
        $this->settings = $settings;
    }

    /**
     * Handles the HTTP GET.
     *
     * @param Request  $request  The request.
     * @param Response $response The Response.
     * @param Variadic $args     Arguments
     *
     */
    public function indexAction(Request $request, Response $response, $args): Response
    {
        $data = [
        ];

        $body = json_encode(['tests']);
        $response->getBody()->write($body);
        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }

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
