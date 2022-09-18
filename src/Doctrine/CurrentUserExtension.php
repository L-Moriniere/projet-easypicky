<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Company;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements \ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public function __construct(private Security $security)
    {
    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, Operation $operation = null, array $context = []): void
    {
        // TODO: Implement applyToCollection() method.
         $this->addWhere($resourceClass, $queryBuilder);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, Operation $operation = null, array $context = []): void
    {
        // TODO: Implement applyToItem() method.
        $this->addWhere($resourceClass, $queryBuilder);
    }

    public function addWhere(string $resourceClass, QueryBuilder $queryBuilder){
        if($resourceClass == Company::class){
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere(":current_user MEMBER OF ". $alias .".users")
                ->setParameter('current_user', $this->security->getUser()->getId());
        }
    }
}