<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922002120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ilogix.empresa (id INT AUTO_INCREMENT NOT NULL, matriz_id INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, apelido VARCHAR(255) NOT NULL, INDEX IDX_EB9EA1F49C36C (matriz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.matriz (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ilogix.empresa ADD CONSTRAINT FK_EB9EA1F49C36C FOREIGN KEY (matriz_id) REFERENCES ilogix.matriz (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ilogix.empresa DROP FOREIGN KEY FK_EB9EA1F49C36C');
        $this->addSql('DROP TABLE ilogix.empresa');
        $this->addSql('DROP TABLE ilogix.matriz');
    }
}
