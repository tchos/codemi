<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922180307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateurs ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateurs ADD CONSTRAINT FK_497B315EB03A8386 FOREIGN KEY (created_by_id) REFERENCES utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_497B315EB03A8386 ON utilisateurs (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateurs DROP CONSTRAINT FK_497B315EB03A8386');
        $this->addSql('DROP INDEX IDX_497B315EB03A8386');
        $this->addSql('ALTER TABLE utilisateurs DROP created_by_id');
    }
}
