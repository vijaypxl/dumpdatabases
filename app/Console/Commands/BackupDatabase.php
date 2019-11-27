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
    protected $signature = 'db:export {username} {password} {db}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Databases';

    protected $process;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $this->process = new Process(sprintf(
                'mysqldump -u%s -p%s %s > %s',
                $this->argument('username'),
                $this->argument('password'),
                $this->argument('db'),
                storage_path('backups/'. $this->argument('db').time() . '.sql')
            ));
            $this->process->mustRun();
            $this->info('The backup of ' . $this->argument('db'). ' is completed');
        } catch (ProcessFailedException $exception) {
            $this->error($exception->getMessage());
            $this->error('The backup process has been failed.');
        }
    }
}
