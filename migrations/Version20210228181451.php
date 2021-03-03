<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228181451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attestation (id INT AUTO_INCREMENT NOT NULL, idservice INT DEFAULT NULL, demande VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX fn_service (idservice), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, idpublication INT DEFAULT NULL, message INT NOT NULL, INDEX fn_pubforum (idpublication), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE embauche (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, iduser INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, local VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, idembauche INT DEFAULT NULL, iduser INT DEFAULT NULL, date DATE NOT NULL, pdf VARCHAR(255) NOT NULL, INDEX fn_embauche (idembauche), INDEX fn_user (iduser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partitipation (id INT AUTO_INCREMENT NOT NULL, idspecialisation INT DEFAULT NULL, iduser INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX fn_spec (idspecialisation), INDEX fn_userp (iduser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, iduser INT DEFAULT NULL, date DATE NOT NULL, description DATE NOT NULL, INDEX fn_iduserrec (iduser), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reduction (id INT AUTO_INCREMENT NOT NULL, idformation INT DEFAULT NULL, pourcentage DOUBLE PRECISION NOT NULL, calcul DOUBLE PRECISION NOT NULL, INDEX fn_formation (idformation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, rdv VARCHAR(255) NOT NULL, rapport VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialisation (id INT AUTO_INCREMENT NOT NULL, idevent INT DEFAULT NULL, idpartitipation INT DEFAULT NULL, text VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX fn_idevent (idevent), INDEX fn_idpartiticip (idpartitipation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, identreprise INT DEFAULT NULL, duree INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX fn_entreprise (identreprise), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, role INT NOT NULL, enabled INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attestation ADD CONSTRAINT FK_326EC63F3E99C8BC FOREIGN KEY (idservice) REFERENCES service (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC69FD17D6 FOREIGN KEY (idpublication) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DADA7FB59D FOREIGN KEY (idembauche) REFERENCES embauche (id)');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DA5E5C27E9 FOREIGN KEY (iduser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE partitipation ADD CONSTRAINT FK_DD2BDA7DA8AE32E9 FOREIGN KEY (idspecialisation) REFERENCES specialisation (id)');
        $this->addSql('ALTER TABLE partitipation ADD CONSTRAINT FK_DD2BDA7D5E5C27E9 FOREIGN KEY (iduser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064045E5C27E9 FOREIGN KEY (iduser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reduction ADD CONSTRAINT FK_B1E754683E5B884A FOREIGN KEY (idformation) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE specialisation ADD CONSTRAINT FK_B9D6A3A2EDAB66BE FOREIGN KEY (idevent) REFERENCES event (id)');
        $this->addSql('ALTER TABLE specialisation ADD CONSTRAINT FK_B9D6A3A2A4B1CDA6 FOREIGN KEY (idpartitipation) REFERENCES partitipation (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369C0B0E75A FOREIGN KEY (identreprise) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY FK_2B58D6DADA7FB59D');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369C0B0E75A');
        $this->addSql('ALTER TABLE specialisation DROP FOREIGN KEY FK_B9D6A3A2EDAB66BE');
        $this->addSql('ALTER TABLE reduction DROP FOREIGN KEY FK_B1E754683E5B884A');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC69FD17D6');
        $this->addSql('ALTER TABLE specialisation DROP FOREIGN KEY FK_B9D6A3A2A4B1CDA6');
        $this->addSql('ALTER TABLE attestation DROP FOREIGN KEY FK_326EC63F3E99C8BC');
        $this->addSql('ALTER TABLE partitipation DROP FOREIGN KEY FK_DD2BDA7DA8AE32E9');
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY FK_2B58D6DA5E5C27E9');
        $this->addSql('ALTER TABLE partitipation DROP FOREIGN KEY FK_DD2BDA7D5E5C27E9');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064045E5C27E9');
        $this->addSql('DROP TABLE attestation');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE embauche');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE partitipation');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reduction');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE specialisation');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE user');
    }
}
