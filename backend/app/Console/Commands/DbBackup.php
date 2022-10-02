<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a back up of the MySQL database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $db = env('DB_DATABASE');

        $filename = 'backup-'.Carbon::now()->format('Y-m-d').'.gz';

        $command = "mysqldump --user={$user} --password={$pass} --host={$host} {$db} | gzip > ".storage_path().'/app/backup/'.$filename;
        $returnVar = null;
        $output = null;
        exec($command, $output, $returnVar);

        return 0;
    }
}
