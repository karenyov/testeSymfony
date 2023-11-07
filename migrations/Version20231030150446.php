<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030150446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log_acesso.usuario_log_acesso (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', usuario_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', user_agent VARCHAR(255) DEFAULT NULL, ip VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, method VARCHAR(10) NOT NULL, params LONGTEXT DEFAULT NULL, data DATETIME NOT NULL, INDEX IDX_C9F211D8DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE log_acesso.usuario_log_acesso ADD CONSTRAINT FK_C9F211D8DB38439E FOREIGN KEY (usuario_id) REFERENCES ilogix.usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log_acesso.usuario_log_acesso DROP FOREIGN KEY FK_C9F211D8DB38439E');
        $this->addSql('DROP TABLE log_acesso.usuario_log_acesso');
    }
}
