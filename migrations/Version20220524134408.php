<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220524134408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE envoye ADD stock_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE envoye ADD CONSTRAINT FK_103D253DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_103D253DCD6110 ON envoye (stock_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE envoye DROP FOREIGN KEY FK_103D253DCD6110');
        $this->addSql('DROP INDEX IDX_103D253DCD6110 ON envoye');
        $this->addSql('ALTER TABLE envoye DROP stock_id');
    }
}
