<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511025052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE discipline_student (discipline_id INT NOT NULL, student_id INT NOT NULL, PRIMARY KEY(discipline_id, student_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DDEBCF6FA5522701 ON discipline_student (discipline_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_DDEBCF6FCB944F1A ON discipline_student (student_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student ADD CONSTRAINT FK_DDEBCF6FA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student ADD CONSTRAINT FK_DDEBCF6FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student DROP CONSTRAINT FK_DDEBCF6FA5522701
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student DROP CONSTRAINT FK_DDEBCF6FCB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE discipline_student
        SQL);
    }
}
