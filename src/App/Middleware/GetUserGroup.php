<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use App\Repositories\UserGroupRepository;

class GetUserGroup
{
    public function __construct(private UserGroupRepository $userGroupRepository)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $context = RouteContext::fromRequest($request);
        $route = $context->getRoute();
        $id = $route->getArgument('id');
        $userGroups = $this->userGroupRepository->getByUserId((int) $id);
        if ($userGroups === false) {
            throw new HttpNotFoundException($request, message: 'user group not found');
        }
        $request = $request->withAttribute('user_groups', $userGroups);
        
        return $handler->handle($request);
    }
}