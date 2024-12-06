<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Repositories\UserRepository;

class UserIndex
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    public function __invoke(Request $request, Response $response): Response
    {
        $body = json_encode($this->userRepository->getAll());
        $response->getBody()->write($body);

        return $response;
    }
}