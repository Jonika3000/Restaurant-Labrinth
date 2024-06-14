<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614163750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_translate DROP CONSTRAINT FK_8D70B14712469DE2');
        $this->addSql('ALTER TABLE category_translate DROP CONSTRAINT FK_8D70B147E559DFD1');
        $this->addSql('ALTER TABLE category_translate ADD CONSTRAINT FK_8D70B14712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_translate ADD CONSTRAINT FK_8D70B147E559DFD1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dish_translate DROP CONSTRAINT FK_90692726E559DFD1');
        $this->addSql('ALTER TABLE dish_translate DROP CONSTRAINT FK_90692726148EB0CB');
        $this->addSql('ALTER TABLE dish_translate ADD CONSTRAINT FK_90692726E559DFD1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dish_translate ADD CONSTRAINT FK_90692726148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_translate DROP CONSTRAINT FK_CC855D4AE559DFD1');
        $this->addSql('ALTER TABLE event_translate ADD CONSTRAINT FK_CC855D4AE559DFD1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event_translate DROP CONSTRAINT fk_cc855d4ae559dfd1');
        $this->addSql('ALTER TABLE event_translate ADD CONSTRAINT fk_cc855d4ae559dfd1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dish_translate DROP CONSTRAINT fk_90692726e559dfd1');
        $this->addSql('ALTER TABLE dish_translate DROP CONSTRAINT fk_90692726148eb0cb');
        $this->addSql('ALTER TABLE dish_translate ADD CONSTRAINT fk_90692726e559dfd1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dish_translate ADD CONSTRAINT fk_90692726148eb0cb FOREIGN KEY (dish_id) REFERENCES dish (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_translate DROP CONSTRAINT fk_8d70b14712469de2');
        $this->addSql('ALTER TABLE category_translate DROP CONSTRAINT fk_8d70b147e559dfd1');
        $this->addSql('ALTER TABLE category_translate ADD CONSTRAINT fk_8d70b14712469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_translate ADD CONSTRAINT fk_8d70b147e559dfd1 FOREIGN KEY (locale_id) REFERENCES site_locale (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
