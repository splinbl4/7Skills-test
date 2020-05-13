<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200513063348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sale_cashbox (id INT AUTO_INCREMENT NOT NULL, timezone INT NOT NULL COMMENT \'(DC2Type:sale_cashbox_timezone)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sale_receipts (id INT AUTO_INCREMENT NOT NULL, receipt_id INT NOT NULL, number VARCHAR(255) NOT NULL COMMENT \'(DC2Type:sale_receipts_number)\', date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total DOUBLE PRECISION NOT NULL COMMENT \'(DC2Type:sale_receipts_total)\', INDEX IDX_39F0F082B5CA896 (receipt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sale_receipts ADD CONSTRAINT FK_39F0F082B5CA896 FOREIGN KEY (receipt_id) REFERENCES sale_cashbox (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sale_receipts DROP FOREIGN KEY FK_39F0F082B5CA896');
        $this->addSql('DROP TABLE sale_cashbox');
        $this->addSql('DROP TABLE sale_receipts');
    }
}
