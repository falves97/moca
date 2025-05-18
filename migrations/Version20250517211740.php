<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250517211740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE subjetive_question (quiz_id INT NOT NULL, id INT NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D790DA42853CD175 ON subjetive_question (quiz_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question ADD CONSTRAINT FK_D790DA42853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question ADD CONSTRAINT FK_D790DA42BF396750 FOREIGN KEY (id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question ADD quiz_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question ADD CONSTRAINT FK_24557253853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_24557253853CD175 ON multiple_choice_question (quiz_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question DROP CONSTRAINT fk_b6f7494e853cd175
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_b6f7494e853cd175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question DROP quiz_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question DROP CONSTRAINT FK_D790DA42853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question DROP CONSTRAINT FK_D790DA42BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE subjetive_question
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question ADD quiz_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question ADD CONSTRAINT fk_b6f7494e853cd175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_b6f7494e853cd175 ON question (quiz_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question DROP CONSTRAINT FK_24557253853CD175
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_24557253853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question DROP quiz_id
        SQL);
    }
}
