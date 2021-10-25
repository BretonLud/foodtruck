<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018084053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_produits (id INT AUTO_INCREMENT NOT NULL, produits_id INT NOT NULL, command_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_5FD53D3DCD11A2CF (produits_id), INDEX IDX_5FD53D3D33E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_produits ADD CONSTRAINT FK_5FD53D3DCD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE order_produits ADD CONSTRAINT FK_5FD53D3D33E1689A FOREIGN KEY (command_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398CD11A2CF');
        $this->addSql('DROP INDEX IDX_F5299398CD11A2CF ON `order`');
        $this->addSql('ALTER TABLE `order` DROP produits_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_produits');
        $this->addSql('ALTER TABLE `order` ADD produits_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398CD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F5299398CD11A2CF ON `order` (produits_id)');
    }
}
