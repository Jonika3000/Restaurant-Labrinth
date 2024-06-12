<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612110057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_8d70b14712469de2');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D70B14712469DE2 ON category_translate (category_id)');
        $this->addSql('DROP INDEX idx_90692726148eb0cb');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_90692726148EB0CB ON dish_translate (dish_id)');
        $this->addSql('DROP INDEX idx_cc855d4a71f7e88b');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC855D4A71F7E88B ON event_translate (event_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_CC855D4A71F7E88B');
        $this->addSql('CREATE INDEX idx_cc855d4a71f7e88b ON event_translate (event_id)');
        $this->addSql('DROP INDEX UNIQ_90692726148EB0CB');
        $this->addSql('CREATE INDEX idx_90692726148eb0cb ON dish_translate (dish_id)');
        $this->addSql('DROP INDEX UNIQ_8D70B14712469DE2');
        $this->addSql('CREATE INDEX idx_8d70b14712469de2 ON category_translate (category_id)');
    }
}
