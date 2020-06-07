<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200601125620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE reserver');
        $this->addSql('ALTER TABLE exemplaire DROP dispo');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reserver (exemplaire_id INT NOT NULL, adherent_id INT NOT NULL, date_reservation DATE NOT NULL, INDEX fk_reserver_adherent (adherent_id), INDEX IDX_B9765E935843AA21 (exemplaire_id), PRIMARY KEY(exemplaire_id, adherent_id, date_reservation)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reserver ADD CONSTRAINT fk_reserver_adherent FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE reserver ADD CONSTRAINT fk_reserver_exemplaire FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id)');
        $this->addSql('ALTER TABLE exemplaire ADD dispo TINYINT(1) NOT NULL');
    }
}
