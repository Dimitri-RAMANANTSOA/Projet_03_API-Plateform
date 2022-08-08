<?php

namespace App\DataProvider;

use Ramsey\Uuid\Uuid;
use App\Entity\Dependency;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

class DependencyDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{
    public function __construct(private string $rootPath){}

    private function getDependencies() : array
    {
        $path = $this->rootPath . '/composer.json';
        $json = json_decode(file_get_contents($path), true);
        return $json['require'];
    }

    public function getCollection(string $ressourceClass, string $operationName = null, array $context = [])
    {
        $items = [];
        foreach ($this->getDependencies() as $name => $version)
        {
            $items[] = new Dependency(Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString(), $name, $version);
        }
        return $items;
    }

    public function supports(string $ressourceClass, string $operationName = null, array $context = []) : bool
    {
        return $ressourceClass === Dependency::class;
    }

    public function getItem (string $ressourceClass, $id, string $operationName = null, array $context = [])
    {
        $dependencies = $this->getDependencies();
        foreach ($dependencies as $name => $version)
        {
            $uuid = Uuid::uuid5(Uuid::NAMESPACE_URL, $name)->toString();
            if ($uuid === $id)
            {
                return new Dependency($uuid, $name, $version);
            }
        }

        return null;
    }
}