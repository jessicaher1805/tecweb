<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use TECWEB\MYAPI\CREATE\Create;
use TECWEB\MYAPI\READ\Read;
use TECWEB\MYAPI\UPDATE\Update;
use TECWEB\MYAPI\DELETE\Delete;

require __DIR__ . '/vendor/autoload.php';


require_once __DIR__ . '/Create/Create.php';
require_once __DIR__ . '/Read/Read.php';
require_once __DIR__ . '/Update/Update.php';
require_once __DIR__ . '/Delete/Delete.php';

$app = AppFactory::create();


$app->addBodyParsingMiddleware();


$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});


$app->addErrorMiddleware(true, true, true);

$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $id = $args['id'];
    
    $read = new Read('marketzone');
    $read->single($id);
    
    $response->getBody()->write($read->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


$app->get('/products', function (Request $request, Response $response) {
    $read = new Read('marketzone');
    $read->list();
    
    $response->getBody()->write($read->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $search = $args['search'];
    
    $read = new Read('marketzone');
    $read->search($search);
    
    $response->getBody()->write($read->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});


$app->post('/product', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    
    $create = new Create('marketzone');
    $create->add(json_decode(json_encode($body)));
    
    $response->getBody()->write($create->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
});


$app->put('/product', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    
    $update = new Update('marketzone');
    $update->edit(json_decode(json_encode($body)));
    
    $response->getBody()->write($update->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->delete('/product', function (Request $request, Response $response) {
    $body = $request->getParsedBody();
    $id = $body['id'] ?? null;
    
    $delete = new Delete('marketzone');
    $delete->delete($id);
    
    $response->getBody()->write($delete->getData());
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->run();
?>