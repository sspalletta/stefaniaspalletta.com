<?php
// please rename to application.config.php ...
return [
	'env'                        => 'development',
	'settings'                   => [
		// Slim Settings
		'displayErrorDetails'               => true,
		'determineRouteBeforeAppMiddleware' => true,
		'addContentLengthHeader'            => false,
	],
];