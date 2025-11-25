<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require 'vendor/autoload.php';

$app = AppFactory::create();

 $app->setBasePath("/tecweb/practicas/p13/pruebaslimv4");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hola Mundo Slim!!!");
    return $response;
});

$app->get("/hola[/{nombre}]", function(Request $request, Response $response, $args) {
    $nombre = $args["nombre"] ?? "Invitado";
    $response->getBody()->write("Hola, " . $nombre);
    return $response;
});

$app->post("/pruebapost", function(Request $request, Response $response, $args) {
    $reqPost = $request->getParsedBody();
    $val1 = $reqPost["val1"] ?? "";
    $val2 = $reqPost["val2"] ?? "";
    
    $response->getBody()->write("Valores: " . $val1 . " " . $val2);
    return $response;
});

$app->get("/testjson", function(Request $request, Response $response, $args) {
    $data[0]["nombre"] = "Sergio";
    $data[0]["apellidos"] = "Rojas Espino";
    $data[1]["nombre"] = "Pedro";
    $data[1]["apellidos"] = "Perez Lopez";
    
    $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
?>