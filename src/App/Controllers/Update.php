<?php
declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

class Update
{
    public function __construct(private PhpRenderer $view)
    {

    }

    public function update(Request $request, Response $response, string $id): Response
    {
    	$user = $request->getAttribute('user');
    	$groups = $request->getAttribute('groups');
    	$userGroups = $request->getAttribute('user_groups');
    	$userGroupIds = [];
    	if (!empty($userGroups)) {
    		$userGroupIds = array_column($userGroups, 'groupid');
    	}

        return $this->view->render($response, 'update.php', ['user' => $user, 'groups' => $groups, 'user_groups' => $userGroupIds]);
    }
}