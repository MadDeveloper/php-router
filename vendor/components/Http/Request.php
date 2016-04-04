<?php

namespace Components\Http;

class Request
{
    private $server;

    public function __construct()
    {
        $this->setServer( $_SERVER );
    }

    public function getMethod( bool $lowerCase = false ) : string
    {
        $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD' );
        return $lowerCase ? strtolower( $method ) : $method;
    }

    public function getPath( bool $lowerCase = false, string $basePath = '' ) : string
    {
        $path = filter_input( INPUT_SERVER, 'REQUEST_URI' );
        $path = strlen( $basePath ) > 0 ? substr( $path, strlen( $basePath ) ) : $path;
        $path = substr( $path, -1 ) === '/' && strlen( $path ) > 1 ? rtrim( $path, '/' ) : $path;

        return $lowerCase ? strtolower( $path ) : $path;
    }

    public function getServer() : array
    {
        return $this->server;
    }

    public function  setServer( array $server ) : Request
    {
        $this->server = $server;
        return $this;
    }
}
