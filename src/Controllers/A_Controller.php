<?php

namespace BlogApiSlim\Controllers;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Message;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class A_Controller
{
    /**
     * @var ?PDO
     */
   protected mixed $pdo;
    protected mixed $container;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container=$container;
        $this->pdo = $container->get('database');


    }

    /**
     * @param array<mixed> $data
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function render(array $data, ResponseInterface $response): ResponseInterface
    {
        $payload = json_encode($data, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    /**
     * @param  Request $request
     * @return mixed[]
     */
    protected function getRequestBodyAsArray(Request $request): array
    {
        $requestBody = explode('&', urldecode($request->getBody()->getContents()));
        $requestBodyParsed = [];
        foreach ($requestBody as $item) {
            $itemTmp = explode('=', $item);
            $requestBodyParsed[$itemTmp[0]] = $itemTmp[1];
        }
        return $requestBodyParsed;
    }
}