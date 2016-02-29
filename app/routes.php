<?php
    
// Routes

$app->get('/', 'BU\Controller\AccountController:indexAction');
$app->post('/account', 'BU\Controller\AccountController:indexAction');

$app->get('/createAccount', 'BU\Controller\AccountController:indexAction');
$app->get('/rpc', 'BU\Controller\AccountController:rpcAction');
$app->get('/rest', 'BU\Controller\AccountController:restAction');
$app->get('/getAccount', 'BU\Controller\AccountController:indexAction');
$app->get('/deleteAccount', 'BU\Controller\AccountController:indexAction');
$app->get('/updateAccount', 'BU\Controller\AccountController:indexAction');

// Route Middleware
$app->get('/rpcserver', function($req, $res, $args){
	// You'll never see this..
	$this->logger('RPC Server Route Called');
})->add(new \DVO\SlimRabbitRest\RpcRequest(
	$container['logger'],
	$app->getContainer(),
	$container['amqp']
));