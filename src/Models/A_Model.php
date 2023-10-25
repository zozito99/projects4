<?php

namespace BlogApiSlim\Models;


use BlogAPiSlim\App\DB;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use PDO;

abstract class A_Model
{
    private ?PDO $pdo;

    abstract function findAll(): array;

    abstract function findById(): array;

    //    abstract function update(int $id): bool;

    abstract function insert(array $data): int;

    abstract function delete(int $id): bool;

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->pdo = $container->get('database');
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}