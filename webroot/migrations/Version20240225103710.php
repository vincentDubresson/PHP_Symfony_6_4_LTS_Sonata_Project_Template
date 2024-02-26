<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225103710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO user (id, gender, firstname, lastname, email, phone, enable, visible, created_at, updated_at, dtype, roles, password) VALUES (1, 'Monsieur', 'John', 'Doe', 'johndoe@test.fr', '+33.6.01.02.03.04', true, false, NOW(), NOW(), 'admin', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$8zXViErj69Qn0q4qrXczxe1ASfH/wkYUPkSGYPO.kBLCPLcfNhZeC')");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM user WHERE email='johndoe@test.fr'");

    }
}
