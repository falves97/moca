<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250620041904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE lesson_student (lesson_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_425FFD94CDF80196 (lesson_id), INDEX IDX_425FFD94CB944F1A (student_id), PRIMARY KEY(lesson_id, student_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lesson_student ADD CONSTRAINT FK_425FFD94CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lesson_student ADD CONSTRAINT FK_425FFD94CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE lesson_student DROP FOREIGN KEY FK_425FFD94CDF80196
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lesson_student DROP FOREIGN KEY FK_425FFD94CB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE lesson_student
        SQL);
    }
}
