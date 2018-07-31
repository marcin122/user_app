<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20180731202730 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('INSERT INTO user(username, password, roles) VALUES(\'test\', \'$2y$13$8NafDlhN/9v.IdnauWcvPOEY8DR1Axz1k407R3Lif.zNJC/W8JiVO\', \'a:1:{i:0;s:9:"ROLE_USER";}\')');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('TRUNCATE user');
    }
}
