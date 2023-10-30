<?php

use BlogApiSlim\App\DB;
use BlogApiSlim\Controllers\ExceptionController;
use BlogApiSlim\Middleware\MiddlewareAfter;
use BlogApiSlim\Middleware\MiddlewareBefore;
use DI\Container;
use Dotenv\Dotenv;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\PhpRenderer;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__."/..");
$dotenv->safeLoad();


$container= new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();


$container->set('database',function (){
$db =new DB();
   return $db->connection;
});
$container->set('view', function () {
    return new PhpRenderer(__DIR__ . "/../Views");
});

$app->group('/v1',function (RouteCollectorProxy$group){
    $group->get('/movies','\BlogApiSlim\Controllers\PostsController:indexAction');
    $group->post('/movies','\BlogApiSlim\Controllers\PostsController:createAction');
    $group->put('/movies/{id:[0-9]+}','\BlogApiSlim\Controllers\PostsController:updateAction');
    $group->delete('/movies/{id:[0-9]+}','\BlogApiSlim\Controllers\PostsController:deleteAction');
    $group->get('/fill_data','\BlogApiSlim\Controllers\PostsController:fakeAction');
    $group->patch('/movies/{id:[0-9]+}', '\BlogApiSlim\Controllers\PostsController:patchAction');
    $group->get('/api','\BlogApiSlim\Controllers\OpenAPIController:documentAction');
})->add(new MiddlewareBefore())->add(new MiddlewareAfter());




$app->get('/v1/routing-name-test/{id:[0-9]+}', function(Request $request, Response $response, $args = []){
    $response->getBody()->write("ID is - " . $args['id']);
    return $response;
})->add(new MiddlewareBefore())->add(new MiddlewareAfter());

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(
    Slim\Exception\HttpNotFoundException::class,
    function (Psr\Http\Message\ServerRequestInterface $request) use ($container)
    {
        $controller = new ExceptionController($container);
        return $controller->notFound($request);
    }
);


$app->run();
