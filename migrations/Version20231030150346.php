<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030150346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compras.pedido (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', empresa_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', num_pedido INT NOT NULL, ano_pedido INT NOT NULL, INDEX IDX_318C40D6521E1991 (empresa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compras.pedido_log (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_usuario_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', log_data DATETIME NOT NULL, log_operacao CHAR(1) NOT NULL, num_pedido INT DEFAULT NULL, ano_pedido INT DEFAULT NULL, empresa_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', pedido_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_7719CDC7D12EEF25 (log_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_bin` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compras.pedido ADD CONSTRAINT FK_318C40D6521E1991 FOREIGN KEY (empresa_id) REFERENCES ilogix.empresa (id)');
        $this->addSql('ALTER TABLE compras.pedido_log ADD CONSTRAINT FK_7719CDC7D12EEF25 FOREIGN KEY (log_usuario_id) REFERENCES ilogix.usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compras.pedido DROP FOREIGN KEY FK_318C40D6521E1991');
        $this->addSql('ALTER TABLE compras.pedido_log DROP FOREIGN KEY FK_7719CDC7D12EEF25');
        $this->addSql('DROP TABLE compras.pedido');
        $this->addSql('DROP TABLE compras.pedido_log');
    }
}
