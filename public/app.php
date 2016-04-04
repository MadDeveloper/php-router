<?php

use Components\Http\Router;
use Components\Http\Request;
use Components\Http\Response;

require( __DIR__ . '/../bootstrap.php' );

$basePath = '/components';
$app = new Router( $basePath );

$app->get( '/', function( Request $request, Response $response ) {
    $response->write( 'Hello World!' );
});

$app->start();
