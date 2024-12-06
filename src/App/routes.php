<?php
declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

use App\Middleware\AddJsonResponseHeader;
use App\Middleware\GetUser;
use App\Middleware\GetGroup;
use App\Middleware\GetUserGroup;
use App\Controllers\UserIndex;
use App\Controllers\Users;
use App\Controllers\Home;
use App\Controllers\Add;
use App\Controllers\Update;

$app->get('/', Home::class);
$app->get('/add', Add::class)->add(GetGroup::class);
$app->get('/update/{id:[0-9]+}', [Update::class, 'update'])
	->add(GetUser::class)
	->add(GetGroup::class)
	->add(GetUserGroup::class);

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->get('/users', UserIndex::class);
    $group->post('/users', [Users::class, 'create']);

    $group->group('', function (RouteCollectorProxy $group) {
        $group->get('/users/{id:[0-9]+}', [Users::class, 'show']);
        $group->patch('/users/{id:[0-9]+}', [Users::class, 'update']);
        $group->delete('/users/{id:[0-9]+}', [Users::class, 'delete']);
    })->add(GetUser::class);
})->add(AddJsonResponseHeader::class);