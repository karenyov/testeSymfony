<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920162512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compras.`pedido_log` (
                        `pedido_id` INT NOT NULL,
                        `empresa_id` INT NULL,
                        `num_pedido` INT(11) NULL,
                        `ano_pedido` INT(11) NULL,
                        `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                        `usuario_id` INT(11) NOT NULL,
                        `operacao` CHAR(1) NOT NULL)
                    ENGINE = InnoDB
                    DEFAULT CHARACTER SET = utf8
                    COLLATE = utf8_bin');

        $this->addSql('CREATE TABLE ilogix.`empresa_log` (
                        `pedido_id` INT NOT NULL,
                        `empresa_id` INT NULL,
                        `num_pedido` INT(11) NULL,
                        `ano_pedido` INT(11) NULL,
                        `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                        `usuario_id` INT(11) NOT NULL,
                        `operacao` CHAR(1) NOT NULL)
                    ENGINE = InnoDB
                    DEFAULT CHARACTER SET = utf8
                    COLLATE = utf8_bin');

        $this->addSql('CREATE TABLE `ilogix`.`matriz_log` (
                        `matriz_id` INT NOT NULL,
                        `nome` VARCHAR(255) NULL,
                        `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                        `usuario_id` INT(11) NULL,
                        `operacao` CHAR(1) NULL)
                    ENGINE = InnoDB
                    DEFAULT CHARACTER SET = utf8
                    COLLATE = utf8_bin');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE compras.pedido_log');
        $this->addSql('DROP TABLE ilogix.empresa_log');
        $this->addSql('DROP TABLE ilogix.matriz_log');
    }
}
