<?php

namespace App\DataProvider;

use Ramsey\Uuid\Uuid;
use App\Entity\Dependency;
use App\Repository\DependencyRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

class DependencyDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{

    public function __construct(private DependencyRepository $repository){}

    public function getCollection(string $ressourceClass, string $operationName = null, array $context = [])
    {
        return $this->repository->findAll();
    }

    public function supports(string $ressourceClass, string $operationName = null, array $context = []) : bool
    {
        return $ressourceClass === Dependency::class;
    }

    public function getItem (string $ressourceClass, $id, string $operationName = null, array $context = [])
    {
        return $this->repository->find($id);
    }
    
}