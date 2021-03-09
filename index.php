<?php

require_once "vendor/autoload.php";
ini_set("display_errors", 1);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r){
    $r->addRoute('GET', '/weatherCitiesList', [\Api\CallMusement::class, 'getWeatherListCities']);
    $r->addRoute('GET', '/getWeatherCity/{city:[a-zA-Z]+}[/{country:[a-zA-Z]+}]', [\Api\CallMusement::class, 'getWeatherCity']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if(false !== $pos = strpos($uri, '?')){
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch($routeInfo[0]){
    case FastRoute\Dispatcher::NOT_FOUND:
        $httpResponseCode = 404;
        header("HTTP/1.0 404 Not Found");
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        header("HTTP/1.0 405 Method Not Allowed");
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        call_user_func_array([new $handler[0], $handler[1]], $vars);
        break;
}