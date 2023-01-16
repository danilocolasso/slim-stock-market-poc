<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class CreateStockMarketTable extends AbstractMigration
{
    public function up(): void
    {
        // I personally don't like using this syntax but idk why Slim doesn't let me use the way I like it

        $table = $this->table('stock_market');

        $table->addColumn('symbol', 'string');
        $table->addColumn('date', 'date');
        $table->addColumn('time', 'string');
        $table->addColumn('open', 'double');
        $table->addColumn('high', 'double');
        $table->addColumn('low', 'double');
        $table->addColumn('close', 'double');
        $table->addColumn('volume', 'double');
        $table->addColumn('name', 'string');
        $table->addTimestamps();

        $table->create();
    }

    public function down(): void
    {
        $this->table('stock_market')->drop();
    }
}
