<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
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
	    $backupPath = storage_path('backups/' . date('Y-m-d-H:i:s') . '-' . config('database.connections.mysql.database') . '.sql');

$command = [
    'mysqldump',
    '-u', config('database.connections.mysql.username'),
    '--password=' . config('database.connections.mysql.password'),
    config('database.connections.mysql.database'),
    '--result-file=' . $backupPath,
    '--no-tablespaces'
];

$this->process = new Process($command);
	    
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
	} catch (ProcessFailedException $exception){
		$this->error($exception);
		//$this->error('The backup process has been failed.');
	}
    }
}
