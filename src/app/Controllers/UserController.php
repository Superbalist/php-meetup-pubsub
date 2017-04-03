<?php

namespace App\Controllers;

use App\Services\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

class UserController
{
    /**
     * @var Twig
     */
    protected $twig;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param Twig $twig
     * @param UserService $userService
     */
    public function __construct(Twig $twig, UserService $userService)
    {
        $this->twig = $twig;
        $this->userService = $userService;
    }

    /**
     * The sign up page.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function signup(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->twig->render($response, 'signup.html');
    }

    /**
     * The form handler for the signup page.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function postSignup(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $params = $request->getParsedBody();
        // last_name is an optional field
        $params['last_name'] = isset($params['last_name']) ? $params['last_name'] : null;

        // create new user
        $user = $this->userService->createUser(
            $params['email'],
            $params['first_name'],
            $params['last_name'],
            $params['password']
        );

        return $this->twig->render($response, 'signup_thanks.html', ['user' => $user]);
    }

    /**
     * The login page.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function login(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        return $this->twig->render($response, 'login.html');
    }

    /**
     * The form handler for the login page.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function postLogin(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $params = $request->getParsedBody();

        // authenticate user
        $user = $this->userService->auth($params['email'], $params['password']);

        return $this->twig->render($response, 'login_thanks.html', ['user' => $user]);
    }
}
