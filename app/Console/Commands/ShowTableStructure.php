<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowTableStructure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:structure {table : The name of the table to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the structure of a database table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');

        if (!Schema::hasTable($table)) {
            $this->error("Table '{$table}' does not exist.");
            return 1;
        }

        $columns = Schema::getColumnListing($table);

        $this->info("Structure of table '{$table}':");

        $headers = ['Column', 'Type', 'Nullable', 'Default', 'Key'];
        $rows = [];

        foreach ($columns as $column) {
            $columnInfo = DB::select("SHOW COLUMNS FROM {$table} WHERE Field = ?", [$column])[0];

            $rows[] = [
                $columnInfo->Field,
                $columnInfo->Type,
                $columnInfo->Null,
                $columnInfo->Default ?? 'NULL',
                $columnInfo->Key
            ];
        }

        $this->table($headers, $rows);

        return 0;
    }
}
