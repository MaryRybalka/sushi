<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210625125700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, entity_item VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_cart (id INT AUTO_INCREMENT NOT NULL, items_list_id INT DEFAULT NULL, session_id VARCHAR(255) NOT NULL, INDEX IDX_CA516ECC412E4E8A (items_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_item (id INT AUTO_INCREMENT NOT NULL, cart_list_id INT DEFAULT NULL, price VARCHAR(10) NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, type_id INT NOT NULL, INDEX IDX_DEE9C365C674DE8C (cart_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shop_cart ADD CONSTRAINT FK_CA516ECC412E4E8A FOREIGN KEY (items_list_id) REFERENCES cart_item (id)');
        $this->addSql('ALTER TABLE shop_item ADD CONSTRAINT FK_DEE9C365C674DE8C FOREIGN KEY (cart_list_id) REFERENCES cart_item (id)');
        $this->addSql('DROP TABLE shop_cart');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('ALTER TABLE Gunkan ADD id INT AUTO_INCREMENT NOT NULL, CHANGE quantity_of_rice quantity_of_rice INT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE Sashimi ADD id INT AUTO_INCREMENT NOT NULL, ADD fish_type VARCHAR(255) NOT NULL, DROP fish_type, CHANGE Calories calories INT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shop_cart DROP FOREIGN KEY FK_CA516ECC412E4E8A');
        $this->addSql('ALTER TABLE shop_item DROP FOREIGN KEY FK_DEE9C365C674DE8C');
        $this->addSql('CREATE TABLE Cart (IDSession VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, ID INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(ID)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE CartItem (IDCart INT NOT NULL, IDItem INT NOT NULL, Quantity INT NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Item (name VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, price VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, type VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE shop_cart');
        $this->addSql('DROP TABLE shop_item');
        $this->addSql('ALTER TABLE Gunkan MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE Gunkan DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE Gunkan DROP id, CHANGE quantity_of_rice QuantityOfRice INT NOT NULL');
        $this->addSql('ALTER TABLE Sashimi MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE Sashimi DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE Sashimi ADD FishType VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, DROP id, DROP fish_type, CHANGE calories Calories VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
    }
}
