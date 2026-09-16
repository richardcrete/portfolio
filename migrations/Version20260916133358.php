<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260916133358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_translation ADD name LONGTEXT NOT NULL');

        $this->addSql("UPDATE project_translation pt JOIN project p ON p.id = pt.translatable_id SET pt.name = p.name WHERE pt.locale = 'fr' AND p.name IS NOT NULL");

        $this->addSql('ALTER TABLE project DROP name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD name LONGTEXT NOT NULL');

        $this->addSql("UPDATE project p JOIN project_translation pt ON pt.translatable_id = p.id AND pt.locale = 'fr' SET p.name = pt.name");

        $this->addSql('ALTER TABLE project_translation DROP name');
    }
}
