<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721193604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD author_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES student (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_9474526CF675F31B ON comment (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum ADD author_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum ADD CONSTRAINT FK_852BBECDF675F31B FOREIGN KEY (author_id) REFERENCES student (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_852BBECDF675F31B ON forum (author_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_9474526CF675F31B ON comment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE comment DROP author_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum DROP FOREIGN KEY FK_852BBECDF675F31B
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_852BBECDF675F31B ON forum
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE forum DROP author_id
        SQL);
    }
}
