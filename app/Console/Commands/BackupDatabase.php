<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class BackupDatabase extends Command
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
    protected $description = 'Backup the database';

    protected $process;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
	    parent::__construct();
	    $file_name = date('Y-m-d-H:i:s') . '-' . config('database.connections.mysql.database') . '.sql';
	    $this->process = new Process(sprintf('mysqldump -u %s --password=%s %s > %s --no-tablespaces',
config('database.connections.mysql.username'),
config('database.connections.mysql.password'),
config('database.connections.mysql.database'),
storage_path('backups/' . $file_name)
));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
	try {
		$this->process->mustRun();
		$this->info('The backup has been proceed successfully.');

	}catch (ProcessFailedException $ex){
		$this->error($ex);
	}
    }
}
