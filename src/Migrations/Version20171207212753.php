<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171207212753 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE market_price (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, price INT NOT NULL, currency VARCHAR(255) NOT NULL, decimals INT NOT NULL, date DATETIME NOT NULL, triggered INT NOT NULL, parser VARCHAR(255) NOT NULL, INDEX type (type), INDEX price (price), INDEX date (date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE triggers (id INT AUTO_INCREMENT NOT NULL, coin VARCHAR(255) NOT NULL, market VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX coin (coin), INDEX date (date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE market_price');
        $this->addSql('DROP TABLE triggers');
    }
}
