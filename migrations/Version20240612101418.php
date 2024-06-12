<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612101418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_translate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dish_translate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE event_translate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE site_locale_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category_translate (id INT NOT NULL, category_id INT NOT NULL, locale_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D70B14712469DE2 ON category_translate (category_id)');
        $this->addSql('CREATE INDEX IDX_8D70B147E559DFD1 ON category_translate (locale_id)');
        $this->addSql('CREATE TABLE dish_translate (id INT NOT NULL, locale_id INT NOT NULL, dish_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_90692726E559DFD1 ON dish_translate (locale_id)');
        $this->addSql('CREATE INDEX IDX_90692726148EB0CB ON dish_translate (dish_id)');
        $this->addSql('CREATE TABLE event_translate (id INT NOT NULL, locale_id INT NOT NULL, event_id INT NOT NULL, name VARCHAR(255) NOT NULL, text TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CC855D4AE559DFD1 ON event_translate (locale_id)');
        $this->addSql('CREATE INDEX IDX_CC855D4A71F7E88B ON event_translate (event_id)');
        $this->addSql('CREATE TABLE site_locale (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE category_translate ADD CONSTRAINT FK_8D70B14712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_translate ADD CONSTRAINT FK_8D70B147E559DFD1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dish_translate ADD CONSTRAINT FK_90692726E559DFD1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dish_translate ADD CONSTRAINT FK_90692726148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_translate ADD CONSTRAINT FK_CC855D4AE559DFD1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_translate ADD CONSTRAINT FK_CC855D4A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_translate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dish_translate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE event_translate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE site_locale_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_translate DROP CONSTRAINT FK_8D70B14712469DE2');
        $this->addSql('ALTER TABLE category_translate DROP CONSTRAINT FK_8D70B147E559DFD1');
        $this->addSql('ALTER TABLE dish_translate DROP CONSTRAINT FK_90692726E559DFD1');
        $this->addSql('ALTER TABLE dish_translate DROP CONSTRAINT FK_90692726148EB0CB');
        $this->addSql('ALTER TABLE event_translate DROP CONSTRAINT FK_CC855D4AE559DFD1');
        $this->addSql('ALTER TABLE event_translate DROP CONSTRAINT FK_CC855D4A71F7E88B');
        $this->addSql('DROP TABLE category_translate');
        $this->addSql('DROP TABLE dish_translate');
        $this->addSql('DROP TABLE event_translate');
        $this->addSql('DROP TABLE site_locale');
        $this->addSql('ALTER TABLE category DROP slug');
    }
}
