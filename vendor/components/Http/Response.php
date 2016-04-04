<?php

namespace Components\Http;

class Response
{
    public static $statusCodeLiteral = [
        'ok' => 200,
        'notFound' => 404
    ];

    public function __construct()
    {

    }

    public function write( string $response )
    {
        $this->sendStatusCode( self::$statusCodeLiteral[ 'ok' ] );
        echo $response;
    }

    public function notFound( string $response = null )
    {
        $this->sendStatusCode( self::$statusCodeLiteral[ 'notFound' ] );
        echo $response ?? "Route not found.";
    }

    public function sendStatusCode( int $statusCode ) : Response
    {
        http_response_code( $statusCode );
        return $this;
    }
}
