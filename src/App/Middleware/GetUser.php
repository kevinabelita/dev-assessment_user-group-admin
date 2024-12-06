<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpNotFoundException;
use App\Repositories\UserRepository;

class GetUser
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $context = RouteContext::fromRequest($request);
        $route = $context->getRoute();
        $id = $route->getArgument('id');
        $user = $this->userRepository->getById((int) $id);
        if ($user === false) {
            throw new HttpNotFoundException($request, message: 'user not found');
        }
        $request = $request->withAttribute('user', $user);
        
        return $handler->handle($request);
    }
}