<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602085927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline ADD banner_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F684EC833 FOREIGN KEY (banner_id) REFERENCES image_file (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_75BEEE3F684EC833 ON discipline (banner_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline DROP CONSTRAINT FK_75BEEE3F684EC833
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_75BEEE3F684EC833
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline DROP banner_id
        SQL);
    }
}
