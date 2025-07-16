<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603104812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE alternative (id INT AUTO_INCREMENT NOT NULL, statement LONGTEXT NOT NULL, is_correct TINYINT(1) NOT NULL, multiple_choice_question_id INT NOT NULL, INDEX IDX_EFF5DFAEB3EBF2 (multiple_choice_question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, knowledge_area VARCHAR(255) NOT NULL, year INT NOT NULL, class VARCHAR(255) NOT NULL, professor_id INT DEFAULT NULL, banner_id INT DEFAULT NULL, INDEX IDX_75BEEE3F7D2D84D5 (professor_id), UNIQUE INDEX UNIQ_75BEEE3F684EC833 (banner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE discipline_student (discipline_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_DDEBCF6FA5522701 (discipline_id), INDEX IDX_DDEBCF6FCB944F1A (student_id), PRIMARY KEY(discipline_id, student_id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE image_file (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, size INT NOT NULL, dimensions LONGTEXT NOT NULL, updated_at DATETIME NOT NULL, discriminator VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE lesson (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, module_id INT DEFAULT NULL, INDEX IDX_F87474F3AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, discipline_id INT DEFAULT NULL, INDEX IDX_C242628A5522701 (discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE multiple_choice_question (quiz_id INT NOT NULL, id INT NOT NULL, INDEX IDX_24557253853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE professor (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, statement LONGTEXT NOT NULL, maximum_possible_points INT NOT NULL, discriminator VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, INDEX IDX_A412FA92AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE student (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE subjetive_question (quiz_id INT NOT NULL, id INT NOT NULL, INDEX IDX_D790DA42853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(180) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(100) NOT NULL, avatar_id INT DEFAULT NULL, discriminator VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE alternative ADD CONSTRAINT FK_EFF5DFAEB3EBF2 FOREIGN KEY (multiple_choice_question_id) REFERENCES multiple_choice_question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F7D2D84D5 FOREIGN KEY (professor_id) REFERENCES professor (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline ADD CONSTRAINT FK_75BEEE3F684EC833 FOREIGN KEY (banner_id) REFERENCES image_file (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student ADD CONSTRAINT FK_DDEBCF6FA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student ADD CONSTRAINT FK_DDEBCF6FCB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE module ADD CONSTRAINT FK_C242628A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question ADD CONSTRAINT FK_24557253853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question ADD CONSTRAINT FK_24557253BF396750 FOREIGN KEY (id) REFERENCES question (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE professor ADD CONSTRAINT FK_790DD7E3BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student ADD CONSTRAINT FK_B723AF33BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question ADD CONSTRAINT FK_D790DA42853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question ADD CONSTRAINT FK_D790DA42BF396750 FOREIGN KEY (id) REFERENCES question (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES image_file (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE alternative DROP FOREIGN KEY FK_EFF5DFAEB3EBF2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F7D2D84D5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline DROP FOREIGN KEY FK_75BEEE3F684EC833
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student DROP FOREIGN KEY FK_DDEBCF6FA5522701
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE discipline_student DROP FOREIGN KEY FK_DDEBCF6FCB944F1A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3AFC2B591
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE module DROP FOREIGN KEY FK_C242628A5522701
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question DROP FOREIGN KEY FK_24557253853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_question DROP FOREIGN KEY FK_24557253BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE professor DROP FOREIGN KEY FK_790DD7E3BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA92AFC2B591
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE student DROP FOREIGN KEY FK_B723AF33BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question DROP FOREIGN KEY FK_D790DA42853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE subjetive_question DROP FOREIGN KEY FK_D790DA42BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D64986383B10
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE alternative
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE discipline
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE discipline_student
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE image_file
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE lesson
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE module
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE multiple_choice_question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE professor
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE student
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE subjetive_question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
