<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231008115852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE agents_invalides_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE decisions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE pages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agents_invalides (id INT NOT NULL, page_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, matricule_armee VARCHAR(8) DEFAULT NULL, matricule_solde VARCHAR(7) DEFAULT NULL, grade VARCHAR(64) DEFAULT NULL, taux_invalidite INT DEFAULT NULL, date_invalidite DATE DEFAULT NULL, rang_instance INT DEFAULT NULL, revalorisation_y_n BOOLEAN DEFAULT NULL, type_agent VARCHAR(32) DEFAULT NULL, auteur_invalide VARCHAR(255) DEFAULT NULL, date_deces_auteur DATE DEFAULT NULL, type_invalidite VARCHAR(16) DEFAULT NULL, rang_decision INT DEFAULT NULL, rang_page INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB503B69C4663E4 ON agents_invalides (page_id)');
        $this->addSql('CREATE TABLE decisions (id INT NOT NULL, numero_decision VARCHAR(255) NOT NULL, date_signature DATE NOT NULL, signataire VARCHAR(64) NOT NULL, ministere VARCHAR(64) NOT NULL, nbre_pages INT NOT NULL, nbre_agents_invalides_decision INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pages (id INT NOT NULL, decision_id INT NOT NULL, numero_page VARCHAR(8) NOT NULL, nbre_agents_invalides_page INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2074E575BDEE7539 ON pages (decision_id)');
        $this->addSql('ALTER TABLE agents_invalides ADD CONSTRAINT FK_AB503B69C4663E4 FOREIGN KEY (page_id) REFERENCES pages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pages ADD CONSTRAINT FK_2074E575BDEE7539 FOREIGN KEY (decision_id) REFERENCES decisions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE agents_invalides_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE decisions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE pages_id_seq CASCADE');
        $this->addSql('ALTER TABLE agents_invalides DROP CONSTRAINT FK_AB503B69C4663E4');
        $this->addSql('ALTER TABLE pages DROP CONSTRAINT FK_2074E575BDEE7539');
        $this->addSql('DROP TABLE agents_invalides');
        $this->addSql('DROP TABLE decisions');
        $this->addSql('DROP TABLE pages');
    }
}
