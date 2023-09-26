<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830122124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, currency VARCHAR(16) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("CREATE TABLE tax (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, quantity INT NOT NULL, country_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB");
        $this->addSql("INSERT INTO coupon (id , code, type , quantity) VALUES (1, 'D10', 'FIXED_AMOUNT_DISCOUNT', 10), (2, 'D15', 'PERCENTAGE_DISCOUNT', 15)");
        $this->addSql("INSERT INTO product (id , name, price, currency) VALUES (1, 'Iphone', 100, '$'), (2, 'Headphones', 20, '$'), (3, 'Cover', 10, '$')");
        $this->addSql("INSERT INTO tax (id , country, quantity ,country_code ) VALUES (1, 'Germany', 19, 'GR'), (2, 'Italy', 22, 'IT'), (3, 'France', 20, 'FR'), (4, 'Greece', 24, 'GR')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DROP TABLE coupon");
        $this->addSql("DROP TABLE product");
        $this->addSql("DROP TABLE tax");
    }
}
