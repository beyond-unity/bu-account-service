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

final class AccountController
{
    /**
     * Logger
     */
    protected $logger;

    /**
     * Handles the HTTP GET.
     *
     * @param LoggerInterface $logger The app.
     *
     */
    public function __construct(
        LoggerInterface $logger,
        AccountFactory $af,
        Client $guzzleclient,
        $settings
    ) {
        $this->logger   = $logger;
        $this->af       = $af;
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
            'error' => 'You must provide a method',
            'token' => $request->getAttribute('token')
        ];

        return $response->withStatus(401)
				        ->withHeader("Content-Type", "application/json")
				        ->write(json_encode($data, JSON_UNESCAPED_SLASHES));
    }

    /**
     * Handles the HTTP GET.
     *
     * @param Request  $request  The request.
     * @param Response $response The Response.
     * @param Variadic $args     Arguments
     *
     */
    public function createAccountAction(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();

        if (true === empty($data['username'])) {
            $data['errors'][] = 'You must supply a username';
        }

        if (true === empty($data['email'])) {
            $data['errors'][] = 'You must supply an email';
        }

        if (true === empty($data['password'])) {
            $data['errors'][] = 'You must supply a password';
        }

        if (true == empty($data['errors'])) {
            $ar            = new AlphaRand();
            $data['vcode'] = $ar->get();
            $account       = $this->af->create($data);
            $created       = $this->af->getGateway()->insertAccount($account);
            $data          = $account->bsonSerialize();
        }

        return $response->withStatus(200)
				        ->withHeader("Content-Type", "application/json")
				        ->write(json_encode($data, JSON_UNESCAPED_SLASHES));
    }

    public function tokenAction(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        if (true === empty($data['username'])) {
            $data['errors'] = 'You must supply a username';
        }

        if (true === empty($data['password'])) {
            $data['errors'] = 'You must supply a password';
        }

        $account = $this->af->getAccount(['username' => $data['username']]);

        if (false === $account->passwordValid($data['password'])) {
            $data['errors'] = 'Invalid username or password';
            return $response->withStatus(401)
                            ->withHeader("Content-Type", "application/json")
                            ->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        }

        $now    = new \DateTime();
        $future = new \DateTime("now +2 hours");
        $server = $request->getServerParams();
        $jti    = base64_encode(random_bytes(16));
        $scopes = [
        	'accounts.verify'
        ];
        if (true === in_array('admin',$account->getRoles())) {
        	$scopes += [
        		'planets.createplanet',
        		'planets.getresources',
        		'planets.asteroidscan'
        	];
        }
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            "sub" => $account->getUsername(),
            "scope" => $scopes,
            "data" => [
            	'roles' => $account->getRoles(),
            	'aid' => $account->getId(),
            	'email' => $account->getEmail(),
            	'username' => $account->getUsername()
            ]
        ];
        $secret = 'mysecret';
        $token = JWT::encode($payload, $secret, "HS256");
        $data["status"] = "ok";
        $data["token"] = $token;
        return $response->withStatus(201)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES));
    }

    public function verifyAction(Request $request, Response $response, $args): Response
    {
    	// need a helper class or sth for this,
    	// as it's going to be repeated a lot..
    	$token   = $request->getAttribute('token');
    	$isAdmin = in_array('admin', $token->data['roles']);

        $data = $request->getParsedBody();

        if (true === empty($data['vcode'])) {
            $data['errors'][] = 'You must supply a verification code';
        }

        // admins can verifiy other accounts ID
        if (false === empty($data['account_id']) && true === $isAdmin) {
        	$account = $this->af->getAccount(['id' => $data['account_id']]);
        } else {
        	$account = $this->af->getAccount(['username' => $token->sub]);
        }

        if (true === empty($account) || false === $account->vcodeValid($data['vcode'])) {
            $data['errors'][] = 'Invalid username or validation code';
            return $response->withStatus(401)
				            ->withHeader("Content-Type", "application/json")
				            ->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        }

        $account->setVerified();
        $this->af->getGateway()->updateAccount($account);

        $data = $account->bsonSerialize();

        return $response->withStatus(200)
				        ->withHeader("Content-Type", "application/json")
				        ->write(json_encode($data, JSON_UNESCAPED_SLASHES));
    }
}
