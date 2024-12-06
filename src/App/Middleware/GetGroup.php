<?php
declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use App\Repositories\GroupRepository;

class GetGroup
{
    public function __construct(private GroupRepository $groupRepository)
    {
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $context = RouteContext::fromRequest($request);
        $groups = $this->groupRepository->getAll();
        $request = $request->withAttribute('groups', $groups);
        
        return $handler->handle($request);
    }
}