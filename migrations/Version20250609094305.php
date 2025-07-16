<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250609094305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE multiple_choice_response (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE multiple_choice_response_alternative (multiple_choice_response_id INT NOT NULL, alternative_id INT NOT NULL, INDEX IDX_7E14D76BEB67350D (multiple_choice_response_id), INDEX IDX_7E14D76BFC05FFAC (alternative_id), PRIMARY KEY(multiple_choice_response_id, alternative_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_response (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_E8BFF2BECB944F1A (student_id), INDEX IDX_E8BFF2BE853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, points INT DEFAULT NULL, question_id INT NOT NULL, discriminator VARCHAR(255) NOT NULL, INDEX IDX_3E7B0BFB1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE subjetive_response (content LONGTEXT NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response ADD CONSTRAINT FK_ACD930E6BF396750 FOREIGN KEY (id) REFERENCES response (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response_alternative ADD CONSTRAINT FK_7E14D76BEB67350D FOREIGN KEY (multiple_choice_response_id) REFERENCES multiple_choice_response (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response_alternative ADD CONSTRAINT FK_7E14D76BFC05FFAC FOREIGN KEY (alternative_id) REFERENCES alternative (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_response ADD CONSTRAINT FK_E8BFF2BECB944F1A FOREIGN KEY (student_id) REFERENCES student (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_response ADD CONSTRAINT FK_E8BFF2BE853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_response ADD CONSTRAINT FK_5F1C98F7BF396750 FOREIGN KEY (id) REFERENCES response (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response DROP FOREIGN KEY FK_ACD930E6BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response_alternative DROP FOREIGN KEY FK_7E14D76BEB67350D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response_alternative DROP FOREIGN KEY FK_7E14D76BFC05FFAC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_response DROP FOREIGN KEY FK_E8BFF2BECB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_response DROP FOREIGN KEY FK_E8BFF2BE853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB1E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_response DROP FOREIGN KEY FK_5F1C98F7BF396750
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE multiple_choice_response
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE multiple_choice_response_alternative
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_response
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE response
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE subjetive_response
        SQL);
    }
}
