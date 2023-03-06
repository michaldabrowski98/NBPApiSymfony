<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230306184042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new entity Currency';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE currency (
                    id INT AUTO_INCREMENT NOT NULL, 
                    name VARCHAR(50) NOT NULL, 
                    currency_code VARCHAR(10) NOT NULL, 
                    exchange_rate VARCHAR(255) NOT NULL, 
                    UNIQUE INDEX currency_code_idx (currency_code), 
                    PRIMARY KEY(id)
                ) 
                DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE currency');
    }
}
