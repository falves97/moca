<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250618181231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response ADD quiz_response_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response ADD CONSTRAINT FK_ACD930E6D4D53BE0 FOREIGN KEY (quiz_response_id) REFERENCES quiz_response (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_ACD930E6D4D53BE0 ON multiple_choice_response (quiz_response_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response DROP FOREIGN KEY FK_ACD930E6D4D53BE0
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_ACD930E6D4D53BE0 ON multiple_choice_response
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE multiple_choice_response DROP quiz_response_id
        SQL);
    }
}
