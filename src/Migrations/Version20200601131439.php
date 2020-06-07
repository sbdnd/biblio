<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601131439 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reserver (date_pret VARCHAR(20) NOT NULL, exemplaire_id INT NOT NULL, adherent_id INT NOT NULL, INDEX IDX_B9765E935843AA21 (exemplaire_id), INDEX IDX_B9765E9325F06C53 (adherent_id), PRIMARY KEY(exemplaire_id, adherent_id, date_pret)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reserver ADD CONSTRAINT FK_B9765E935843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id)');
        $this->addSql('ALTER TABLE reserver ADD CONSTRAINT FK_B9765E9325F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('DROP TABLE emprunter');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE emprunter (date_pret VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, exemplaire_id INT NOT NULL, adherent_id INT NOT NULL, date_retour_prevue DATETIME NOT NULL, date_retour_reelle DATETIME DEFAULT NULL, INDEX IDX_E23B93F25F06C53 (adherent_id), INDEX IDX_E23B93F5843AA21 (exemplaire_id), PRIMARY KEY(exemplaire_id, adherent_id, date_pret)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE emprunter ADD CONSTRAINT FK_E23B93F25F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE emprunter ADD CONSTRAINT FK_E23B93F5843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id)');
        $this->addSql('DROP TABLE reserver');
    }
}
