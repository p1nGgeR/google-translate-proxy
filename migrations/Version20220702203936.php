<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220702203936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE translation (id INT AUTO_INCREMENT NOT NULL, language VARCHAR(50) NOT NULL, text LONGTEXT NOT NULL, search_key VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_B469456F4E2BDF16 (search_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE translation_translations (source_translation_id INT NOT NULL, target_translation_id INT NOT NULL, INDEX IDX_B12BF45B3FD34780 (source_translation_id), INDEX IDX_B12BF45B20D0240C (target_translation_id), PRIMARY KEY(source_translation_id, target_translation_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE translation_translations ADD CONSTRAINT FK_B12BF45B3FD34780 FOREIGN KEY (source_translation_id) REFERENCES translation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE translation_translations ADD CONSTRAINT FK_B12BF45B20D0240C FOREIGN KEY (target_translation_id) REFERENCES translation (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE translation_translations DROP FOREIGN KEY FK_B12BF45B3FD34780');
        $this->addSql('ALTER TABLE translation_translations DROP FOREIGN KEY FK_B12BF45B20D0240C');
        $this->addSql('DROP TABLE translation');
        $this->addSql('DROP TABLE translation_translations');
    }
}
