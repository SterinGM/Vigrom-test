<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414195027 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, wallet_id INT NOT NULL, type VARCHAR(255) CHECK(type IN (\'DEBIT\', \'CREDIT\')) NOT NULL, reason VARCHAR(255) CHECK(reason IN (\'STOCK\', \'REFUND\')) NOT NULL, amount INT NOT NULL, currency VARCHAR(255) CHECK(currency IN (\'RUB\', \'USD\')) NOT NULL, balance INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D1712520F3 ON transaction (wallet_id)');
        $this->addSql('COMMENT ON COLUMN transaction.type IS \'(DC2Type:TransactionType)\'');
        $this->addSql('COMMENT ON COLUMN transaction.reason IS \'(DC2Type:ReasonType)\'');
        $this->addSql('COMMENT ON COLUMN transaction.currency IS \'(DC2Type:CurrencyType)\'');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE transaction');
    }
}
