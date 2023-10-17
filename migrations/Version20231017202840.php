<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017202840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients_months_limit (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, used INT NOT NULL, `limit` INT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_3CFB0AE219EB6921 (client_id), UNIQUE INDEX client_date_uidx (client_id, date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients_packets (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, packet_id INT NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_72319B8519EB6921 (client_id), UNIQUE INDEX packet_uidx (packet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE packets_updates (id INT AUTO_INCREMENT NOT NULL, used INT NOT NULL, `limit` INT NOT NULL, packet_id INT NOT NULL, timestamp DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clients_months_limit ADD CONSTRAINT FK_3CFB0AE219EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE clients_packets ADD CONSTRAINT FK_72319B8519EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients_months_limit DROP FOREIGN KEY FK_3CFB0AE219EB6921');
        $this->addSql('ALTER TABLE clients_packets DROP FOREIGN KEY FK_72319B8519EB6921');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE clients_months_limit');
        $this->addSql('DROP TABLE clients_packets');
        $this->addSql('DROP TABLE packets_updates');
    }
}
