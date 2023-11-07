<?php

namespace App\Core\EventSubscriber;

use App\Core\Repository\UsuarioRepository;
use App\Core\Enum\Operacao;
use App\Core\Security\ApiKeyUser;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntitySubscriber implements EventSubscriber
{
    private const INSERT_ACTION = Operacao::INSERT_ACTION;
    private const UPDATE_ACTION = Operacao::UPDATE_ACTION;
    private const DELETE_ACTION = Operacao::DELETE_ACTION;

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly UsuarioRepository $usuarioRepository,
        private readonly ApiKeyUser $apiKeyUser
    ) {
        $this->entityManager = $entityManager;
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::preRemove,
            Events::onFlush
        ];
    }

    private function getLogClassName(object $entity): ?string
    {
        $entityClassName = get_class($entity);
        $lastNamespaceSeparator = strrpos($entityClassName, '\\');

        if ($lastNamespaceSeparator !== false) {
            $namespace = substr($entityClassName, 0, $lastNamespaceSeparator);
            $className = substr($entityClassName, $lastNamespaceSeparator + 1);
            $logClassName = $namespace . '\\Log\\' . $className . 'Log';

            if (class_exists($logClassName)) {
                return $logClassName;
            }
        }

        return null;
    }

    private function createLogEntity(object $entity, Operacao $action): ?object
    {
        $logClassName = $this->getLogClassName($entity);
        $usuario = $this->apiKeyUser->getUserFromToken();

        if ($logClassName === null || !class_exists($logClassName) || $usuario === null) {
            return null;
        }

        $logEntity = new $logClassName();
        $logEntity->setLogData(new \DateTimeImmutable());
        $logEntity->setLogOperacao($action);
        $logEntity->setLogUsuario($usuario);

        return $logEntity;
    }

    private function classBasename(string $class): string
    {
        $parts = explode('\\', $class);
        return end($parts);
    }


    private function addChangeToLogEntity(object $logEntity, string $propertyName, $newValue, $isId): void
    {
        $setterMethod =  $isId ? ('set' . ucfirst($propertyName) . "Id") : ('set' . ucfirst($propertyName));
        if (method_exists($logEntity, $setterMethod)) {
            $logEntity->$setterMethod($newValue);
        }
    }

    public function onFlush($args): void
    {
        $entityManager = $args->getObjectManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $changeset = $unitOfWork->getEntityChangeSet($entity);
            $logClassName = $this->getLogClassName($entity);

            if (!empty($changeset) && $logClassName !== null) {
                $logEntity = $this->createLogEntity($entity, self::UPDATE_ACTION);

                $className = strtolower($this->classBasename(get_class($entity)));

                $id = $entity->getId();
                $this->addChangeToLogEntity($logEntity, $className, $id, true);
                if ($logEntity !== null) {
                    foreach ($changeset as $propertyName => $change) {
                        $oldValue = $change[0];
                        $newValue = $change[1];

                        $isId = is_object($oldValue) && method_exists($oldValue, 'getId');
                        $oldValue = $isId ? $oldValue->getId() : $oldValue;
                        $newValue = $isId ? $newValue->getId() : $newValue;

                        if ($oldValue !== $newValue) {
                            $this->addChangeToLogEntity($logEntity, $propertyName, $newValue, $isId);
                        }
                    }
                    $entityManager->persist($logEntity);
                    $unitOfWork->computeChangeSet($entityManager->getClassMetadata(get_class($logEntity)), $logEntity);
                }
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args): void
    {

        $this->processEvent($args, self::INSERT_ACTION);
    }

    public function preRemove(LifecycleEventArgs $args): void
    {
        $this->processEvent($args, self::DELETE_ACTION);
    }

    private function processEvent(LifecycleEventArgs $args, Operacao $action): void
    {
        $entity = $args->getObject();
        $logClassName = $this->getLogClassName($entity);

        $entityClassName = get_class($entity);
        if ($logClassName !== null && class_exists($logClassName)) {
            $logEntity = $this->createLogEntity($entity,  $action);

            if ($logEntity) {
                $this->copyProperties($entity, $logEntity, $entityClassName, $action);

                $logRepository = $this->entityManager->getRepository($logClassName);
                $logRepository->save($logEntity);
            }
        }
    }

    private function copyProperties(object $source, object $destination, string $associatedEntityClass, Operacao $action): void
    {
        $sourceReflection = new \ReflectionObject($source);
        $destinationReflection = new \ReflectionObject($destination);

        $destinationProperties = $destinationReflection->getProperties();

        $associatedEntityClassName = substr($associatedEntityClass, strrpos($associatedEntityClass, '\\') + 1);
        $logPropertyName = lcfirst($associatedEntityClassName);

        foreach ($destinationProperties as $destProperty) {
            $destProperty->setAccessible(true);
            $name = $destProperty->getName();

            if ($name === $logPropertyName . "Id") {
                $sourceProperty = $sourceReflection->getProperty("id");
                $setterMethod = 'set' . ucfirst($associatedEntityClassName) . 'Id';

                if (method_exists($destination, $setterMethod)) {
                    $destination->$setterMethod($sourceProperty->getValue($source));
                }
                continue;
            }

            if ($action === self::DELETE_ACTION) {
                continue;
            }

            $this->copyPropertyValue($source, $destination, $sourceReflection, $destProperty, $name);
        }
    }

    private function copyPropertyValue(object $source, object $destination, \ReflectionObject $sourceReflection, \ReflectionProperty $destProperty, string $name): void
    {
        $isEntity = false;
        $propertyName = $name;

        if (substr($name, -2) === 'Id') {
            $propertyName = substr($name, 0, -2);
            $isEntity = true;
        }

        if ($sourceReflection->hasProperty($propertyName)) {
            $sourceProperty = $sourceReflection->getProperty($propertyName);
            $sourceProperty->setAccessible(true);

            if ($isEntity) {
                $destProperty->setValue($destination, $sourceProperty->getValue($source)->getId());
            } else {
                $destProperty->setValue($destination, $sourceProperty->getValue($source));
            }
        }
    }
}
