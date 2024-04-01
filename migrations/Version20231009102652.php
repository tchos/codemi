<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231009102652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE decisions ADD user_decision_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE decisions ADD CONSTRAINT FK_638DAA1714F5BCAC FOREIGN KEY (user_decision_id) REFERENCES utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_638DAA1714F5BCAC ON decisions (user_decision_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE decisions DROP CONSTRAINT FK_638DAA1714F5BCAC');
        $this->addSql('DROP INDEX IDX_638DAA1714F5BCAC');
        $this->addSql('ALTER TABLE decisions DROP user_decision_id');
    }
}
