<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixPostgresSequences extends Command
{
    protected $signature = 'db:fix-sequences';
    protected $description = 'Fix PostgreSQL sequences after manual inserts';

    public function handle()
    {
        $tables = ['users', 'posts', 'comments', 'likes'];

        foreach ($tables as $table) {
            // Obtenir la valeur maximale de l'ID
            $maxId = DB::table($table)->max('id') ?? 0;
            
            // Réinitialiser la séquence
            DB::statement("ALTER SEQUENCE {$table}_id_seq RESTART WITH " . ($maxId + 1));
            
            $this->info("Fixed sequence for table {$table}. Next ID will be " . ($maxId + 1));
        }

        $this->info('All sequences have been fixed!');
    }
}