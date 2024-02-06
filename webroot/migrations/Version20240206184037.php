<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206184037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO abstract_user (firstname, lastname, email, enabled, dtype, roles, password) VALUES ('John', 'Doe', 'johndoe@test.fr', true, 'user', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$8zXViErj69Qn0q4qrXczxe1ASfH/wkYUPkSGYPO.kBLCPLcfNhZeC')");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM abstract_user WHERE email='johndoe@test.fr'");

    }
}
