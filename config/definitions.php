<?php
declare(strict_types=1);

use Slim\Views\PhpRenderer;
use App\Database;

return [
	Database::class => function () {
		return new Database(
			host: $_ENV['DB_HOST'],
			name: $_ENV['DB_NAME'],
			user: $_ENV['DB_USER'],
			password: $_ENV['DB_PASSWORD']
		);
	},
	PhpRenderer::class => function () {
		$renderer = new PhpRenderer(__DIR__ . '/../views');
		$renderer->setLayout('layout.php');

		return $renderer;
	},
];