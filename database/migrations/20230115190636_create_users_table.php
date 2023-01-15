<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('users');

        $table->addColumn('name', 'string');
        $table->addColumn('username', 'string');
        $table->addColumn('password', 'string');
        $table->addIndex('username', ['unique' => true]);
        $table->addTimestamps();

        $table->create();
    }

    public function down(): void
    {
        $this->table('users')->drop();
    }
}
