<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Repositories\UserRepository;
use App\Repositories\UserGroupRepository;
use Valitron\Validator;

class Users
{
    public function __construct(
        private UserRepository $userRepository, 
        private UserGroupRepository $userGroupRepository,
        private Validator $validator
    ) {
        $this->validator->mapFieldsRules([
            'email' => ['required', 'email'],
            'name' => ['required'],
            'phone' => ['required', 'numeric'],
        ]);
    }

    public function show(Request $request, Response $response, string $id): Response
    {
        $user = $request->getAttribute('user');
        $response->getBody()->write(json_encode($user));

        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();
        $this->validator = $this->validator->withData($body);
        if (!$this->validator->validate()) {
            $response->getBody()->write(json_encode($this->validator->errors()));

            return $response->withStatus(422); // Unprocessable Content
        }
        $userId = $this->userRepository->create($body);
        $this->userGroupRepository->updateByUserId($userId, $body['usergroups']);
        $body = json_encode(['message' => 'User created', 'userid' => $userId]);
        $response->getBody()->write($body);

        return $response->withStatus(201); // Created
    }

    public function update(Request $request, Response $response, string $id): Response
    {
        $body = $request->getParsedBody();
        $this->validator = $this->validator->withData($body);
        if (!$this->validator->validate()) {
            $response->getBody()->write(json_encode($this->validator->errors()));

            return $response->withStatus(422); // Unprocessable Content
        }
        $rows = $this->userRepository->update((int) $id, $body);
        $this->userGroupRepository->updateByUserId((int) $id, $body['usergroups']);
        $body = json_encode(['message' => 'User updated', 'rows' => $rows]);
        $response->getBody()->write($body);

        return $response;
    }

    public function delete(Request $request, Response $response, string $id): Response
    {
        $rows = $this->userRepository->delete((int) $id);
        $body = json_encode(['message' => 'User deleted', 'rows' => $rows]);
        $response->getBody()->write($body);

        return $response;
    }
}