<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030150324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ilogix.empresa (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', matriz_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, apelido VARCHAR(255) NOT NULL, INDEX IDX_EB9EA1F49C36C (matriz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.empresa_log (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_usuario_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_data DATETIME NOT NULL, log_operacao CHAR(1) NOT NULL, nome VARCHAR(255) DEFAULT NULL, apelido VARCHAR(255) DEFAULT NULL, empresa_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', matriz_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_CBF05BFCD12EEF25 (log_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.funcionalidade (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.grupo (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.grupo_funcionalidade (grupo_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', funcionalidade_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_47F2385F9C833003 (grupo_id), INDEX IDX_47F2385F383FCED8 (funcionalidade_id), PRIMARY KEY(grupo_id, funcionalidade_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.matriz (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.matriz_log (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_usuario_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_data DATETIME NOT NULL, log_operacao CHAR(1) NOT NULL, nome VARCHAR(255) DEFAULT NULL, matriz_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_86D6104BD12EEF25 (log_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.refresh_tokens (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', refresh_token VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.url (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', funcionalidade_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', route VARCHAR(255) NOT NULL, http_get TINYINT(1) DEFAULT 0, http_post TINYINT(1) DEFAULT 0, http_put TINYINT(1) DEFAULT 0, http_delete TINYINT(1) DEFAULT 0, INDEX IDX_9E76442D383FCED8 (funcionalidade_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.usuario (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', grupo_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, senha VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_712C4BF9E7927C74 (email), INDEX IDX_712C4BF99C833003 (grupo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ilogix.usuario_log (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_usuario_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_data DATETIME NOT NULL, log_operacao CHAR(1) NOT NULL, usuario_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', grupo_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', nome VARCHAR(255) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, INDEX IDX_5BC66037D12EEF25 (log_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ilogix.empresa ADD CONSTRAINT FK_EB9EA1F49C36C FOREIGN KEY (matriz_id) REFERENCES ilogix.matriz (id)');
        $this->addSql('ALTER TABLE ilogix.empresa_log ADD CONSTRAINT FK_CBF05BFCD12EEF25 FOREIGN KEY (log_usuario_id) REFERENCES ilogix.usuario (id)');
        $this->addSql('ALTER TABLE ilogix.grupo_funcionalidade ADD CONSTRAINT FK_47F2385F9C833003 FOREIGN KEY (grupo_id) REFERENCES ilogix.grupo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ilogix.grupo_funcionalidade ADD CONSTRAINT FK_47F2385F383FCED8 FOREIGN KEY (funcionalidade_id) REFERENCES ilogix.funcionalidade (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ilogix.matriz_log ADD CONSTRAINT FK_86D6104BD12EEF25 FOREIGN KEY (log_usuario_id) REFERENCES ilogix.usuario (id)');
        $this->addSql('ALTER TABLE ilogix.url ADD CONSTRAINT FK_9E76442D383FCED8 FOREIGN KEY (funcionalidade_id) REFERENCES ilogix.funcionalidade (id)');
        $this->addSql('ALTER TABLE ilogix.usuario ADD CONSTRAINT FK_712C4BF99C833003 FOREIGN KEY (grupo_id) REFERENCES ilogix.grupo (id)');
        $this->addSql('ALTER TABLE ilogix.usuario_log ADD CONSTRAINT FK_5BC66037D12EEF25 FOREIGN KEY (log_usuario_id) REFERENCES ilogix.usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ilogix.empresa DROP FOREIGN KEY FK_EB9EA1F49C36C');
        $this->addSql('ALTER TABLE ilogix.empresa_log DROP FOREIGN KEY FK_CBF05BFCD12EEF25');
        $this->addSql('ALTER TABLE ilogix.grupo_funcionalidade DROP FOREIGN KEY FK_47F2385F9C833003');
        $this->addSql('ALTER TABLE ilogix.grupo_funcionalidade DROP FOREIGN KEY FK_47F2385F383FCED8');
        $this->addSql('ALTER TABLE ilogix.matriz_log DROP FOREIGN KEY FK_86D6104BD12EEF25');
        $this->addSql('ALTER TABLE ilogix.url DROP FOREIGN KEY FK_9E76442D383FCED8');
        $this->addSql('ALTER TABLE ilogix.usuario DROP FOREIGN KEY FK_712C4BF99C833003');
        $this->addSql('ALTER TABLE ilogix.usuario_log DROP FOREIGN KEY FK_5BC66037D12EEF25');
        $this->addSql('DROP TABLE ilogix.empresa');
        $this->addSql('DROP TABLE ilogix.empresa_log');
        $this->addSql('DROP TABLE ilogix.funcionalidade');
        $this->addSql('DROP TABLE ilogix.grupo');
        $this->addSql('DROP TABLE ilogix.grupo_funcionalidade');
        $this->addSql('DROP TABLE ilogix.matriz');
        $this->addSql('DROP TABLE ilogix.matriz_log');
        $this->addSql('DROP TABLE ilogix.refresh_tokens');
        $this->addSql('DROP TABLE ilogix.url');
        $this->addSql('DROP TABLE ilogix.usuario');
        $this->addSql('DROP TABLE ilogix.usuario_log');
    }
}
