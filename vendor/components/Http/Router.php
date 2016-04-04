<?php

namespace Components\Http;

class Router
{
    private $routes;
    private $request;
    private $response;
    private $basePath;

    public function __construct( string $basePath = '' )
    {
        $this->routes = [];
        $this->setBasePath( $basePath );
        $this->setRequest( new Request() );
        $this->setResponse( new Response() );
    }

    /*
     * Routes methods
     */
    public function get( string $route, $callback ) : Router
    {
        if ( !$this->methodAlreadyRegistered( 'get' ) ) {
            $this->registerMethod( 'get' );
        }

        if ( !$this->routeAlreadyDefined( 'get', $route ) ) {
            $this->defineRoute( 'get', $route, $callback );
        }

        return $this;
    }

    public function start()
    {
        $method = $this->getRequest()->getMethod( true );
        $this->resolveRoute( $method, $this->getRequest()->getPath( true, $this->getBasePath() ) );
    }

    public function resolveRoute( string $method, string $route )
    {
        if ( $this->methodAlreadyRegistered( $method ) && $this->routeAlreadyDefined( $method, $route ) ) {
            $this->callRouteCallback( $method, $route );
        } else {
            $this->getResponse()->notFound();
        }
    }

    protected function callRouteCallback( string $method, string $route )
    {
        $this->routes[ strtolower( $method ) ][ strtolower( $route ) ]( $this->getRequest(), $this->getResponse() );
    }

    protected function methodAlreadyRegistered( string $method ) : bool
    {
        return array_key_exists( $method, $this->getRoutes() );
    }

    protected function registerMethod( string $method ) : Router
    {
        $this->routes[ strtolower( $method ) ] = [];
        return $this;
    }

    public function routeAlreadyDefined( string $method, string $route ) : bool
    {
        return $this->methodAlreadyRegistered( $method ) && array_key_exists( strtolower( $route ), $this->routes[ $method ] );
    }

    protected function defineRoute( string $method, string $route, $callback ) : Router
    {
        $this->routes[ strtolower( $method ) ][ strtolower( $route ) ] = $callback;
        return $this;
    }

    public function getRoutes() : array
    {
        return $this->routes;
    }

    protected function setRoutes( array $routes ) : Router
    {
        $this->routes = $routes;
        return $this;
    }

    public function getRequest() : Request
    {
        return $this->request;
    }

    protected function setRequest( Request $request ) : Router
    {
        $this->request = $request;
        return $this;
    }

    public function getResponse() : Response
    {
        return $this->response;
    }

    protected function setResponse( Response $response ) : Router
    {
        $this->response = $response;
        return $this;
    }

    public function getBasePath() : string
    {
        return $this->basePath;
    }

    public function setBasePath( string $basePath ) : Router
    {
        $this->basePath = $basePath;
        return $this;
    }
}
