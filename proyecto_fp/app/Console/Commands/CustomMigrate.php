<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.Migraciones
     */
    public function handle()
    {
         $this->call('migrate', ['--path' => 'database/migrations/2023_01_01_000000_create_users_table.php']);
        $this->call('migrate', ['--path' => 'database/migrations/2023_01_02_000000_create_posts_table.php']);
   
    }
}
