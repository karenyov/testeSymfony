<?php

namespace App\Core\EventListener;

use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Mapping\Entity;

class DoctrineForeignKeysListener
{
    /**
     * Generate foreign keys to other databases
     *
     * @param GenerateSchemaEventArgs $args
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args)
    {
        $em = $args->getEntityManager();
        $schema = $args->getSchema();
        $mainSchemaName = $args->getSchema()->getName();

        /**
         * @var \Doctrine\ORM\Mapping\ClassMetadata $metaData
         */
        foreach ($em->getMetadataFactory()->getAllMetadata() as $metaData) {
            $classAnnotations = $metaData->getReflectionClass()->getAttributes(Entity::class);
            if (empty($classAnnotations)) {
                continue;
            }

            $schemaName = $metaData->getSchemaName();
            // this is an entity on another database, we don't want to handle it
            if ($schemaName && $schemaName != $mainSchemaName) {
                continue;
            }

            // fetch all relations of the entity
            foreach ($metaData->associationMappings as $field => $mapping) {
                $targetMetaData = $em->getClassMetadata($mapping['targetEntity']);
                $targetSchemaName = $targetMetaData->getSchemaName();
                // the relation is on the same schema, so no problem here
                if (!$targetSchemaName || $targetSchemaName == $mainSchemaName) {
                    continue;
                }

                if (!empty($mapping['joinTable'])) {
                    foreach ($mapping['joinTable']['inverseJoinColumns'] as $inverseColumn) {
                        $options = array();
                        if (!empty($inverseColumn['onDelete'])) {
                            $options['onDelete'] = $inverseColumn['onDelete'];
                        }
                        // add the foreign key
                        $schema->getTable($mapping['joinTable']['name'])
                            ->addForeignKeyConstraint(
                                $targetSchemaName . '.' . $targetMetaData->getTableName(),
                                [$inverseColumn['name']],
                                [$inverseColumn['referencedColumnName']],
                                $options
                            );
                    }
                } elseif (!empty($mapping['joinColumns'])) {
                    foreach ($mapping['joinColumns'] as $joinColumn) {
                        // add the foreign key
                        $options = array();
                        if (!empty($joinColumn['onDelete'])) {
                            $options['onDelete'] = $joinColumn['onDelete'];
                        }
                        $schema->getTable($metaData->getTableName())
                            ->addForeignKeyConstraint(
                                $targetSchemaName . '.' . $targetMetaData->getTableName(),
                                [$joinColumn['name']],
                                [$joinColumn['referencedColumnName']],
                                $options
                            );
                    }
                }
            }
        }
    }
}
