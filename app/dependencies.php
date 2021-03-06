<?php
// DIC configuration
$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------
/*
$container['amqp'] = function($c) {
    $settings = $c->get('settings');
    return new \PhpAmqpLib\Connection\AMQPConnection(
        $settings['account.service.amqp']['host'],
        $settings['account.service.amqp']['port'],
        $settings['account.service.amqp']['user'],
        $settings['account.service.amqp']['pass']
    );
};
*/


$container['mongo'] = function ($c) {
    $settings = $c->get('settings');
    $mongo    = new \MongoDB\Driver\Manager($settings['mongohost']);
    $db       = new \MongoDB\Database($mongo, $settings['mongodb']);

    return $db;
};


// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

$container['guzzle.client'] = function($c) {
    return new GuzzleHttp\Client(
        ['defaults' => [
            'headers'  => ['Content-Type' => 'application/json', 'Accept' => 'application/json']]]
    );
};

// -----------------------------------------------------------------------------
// Data factories
// -----------------------------------------------------------------------------

$container['account.gateway'] = function ($c) {
    return new BU\Entity\Account\AccountGateway($c->get('mongo'));
};

$container['account.factory'] = function ($c) {
    return new BU\Entity\Account\AccountFactory($c->get('account.gateway'));
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container['BU\Controller\AccountController'] = function ($c) {
    return new BU\Controller\AccountController(
        $c->get('logger'),
        $c->get('account.factory'),
        $c->get('guzzle.client'),
        $c->get('settings')
    );
};
