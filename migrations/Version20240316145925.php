<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316145925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order" ADD weight_detail_fabricants_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD weight_detail_occasion_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD weight_detail_others_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD weight_detail_tiers_id INT NOT NULL');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398C23DE17 FOREIGN KEY (weight_detail_fabricants_id) REFERENCES weight_detail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F52993986D4A6784 FOREIGN KEY (weight_detail_occasion_id) REFERENCES weight_detail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398358B1EB FOREIGN KEY (weight_detail_others_id) REFERENCES weight_detail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_F5299398D6F92AD6 FOREIGN KEY (weight_detail_tiers_id) REFERENCES weight_detail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398C23DE17 ON "order" (weight_detail_fabricants_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F52993986D4A6784 ON "order" (weight_detail_occasion_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398358B1EB ON "order" (weight_detail_others_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398D6F92AD6 ON "order" (weight_detail_tiers_id)');
        $this->addSql('ALTER TABLE weight_detail DROP CONSTRAINT fk_e5586b4ab88abbf');
        $this->addSql('DROP INDEX idx_e5586b4ab88abbf');
        $this->addSql('ALTER TABLE weight_detail ADD delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE weight_detail DROP ref_order_id');
        $this->addSql('COMMENT ON COLUMN weight_detail.delivered_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weight_detail ADD ref_order_id INT NOT NULL');
        $this->addSql('ALTER TABLE weight_detail DROP delivered_at');
        $this->addSql('ALTER TABLE weight_detail ADD CONSTRAINT fk_e5586b4ab88abbf FOREIGN KEY (ref_order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e5586b4ab88abbf ON weight_detail (ref_order_id)');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398C23DE17');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F52993986D4A6784');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398358B1EB');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_F5299398D6F92AD6');
        $this->addSql('DROP INDEX UNIQ_F5299398C23DE17');
        $this->addSql('DROP INDEX UNIQ_F52993986D4A6784');
        $this->addSql('DROP INDEX UNIQ_F5299398358B1EB');
        $this->addSql('DROP INDEX UNIQ_F5299398D6F92AD6');
        $this->addSql('ALTER TABLE "order" DROP weight_detail_fabricants_id');
        $this->addSql('ALTER TABLE "order" DROP weight_detail_occasion_id');
        $this->addSql('ALTER TABLE "order" DROP weight_detail_others_id');
        $this->addSql('ALTER TABLE "order" DROP weight_detail_tiers_id');
    }
}
