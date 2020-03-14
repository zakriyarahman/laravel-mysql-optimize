<?php

namespace Zaks\MySQLOptimier\Console\Commands;

use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:optimize
                        {--database=default}
                        {--table=*}';

    /**
     * ConversiSelectioSelection query
     *
     * @var string
     */
    protected $query = 'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'Table optimizer for database';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Optimize table/s of the database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Starting Optimization.');

        dd($this->getTables())
            ->tap(function($collection) {
                $this->progress = $this->output->createProgressBar($collection->count());
            })->each(function($table){
                $this->optimize($table);
            });

        $this->info(PHP_EOL.'Optimization Completed');
    }

    /**
     * Get database which need optimization
     *
     * @return string
     */
    protected function getDatabase()
    {
        if($database = $this->option('database') == 'default') {
            $database = env('DB_DATABASE');
        }
        return  $database;
    }

    /**
     * Get all the tables that need to the optimized
     *
     * @return array
     */
    private function getTables()
    {
        $tables = $this->option('table');
        if (empty($tables)) {
            $tables = DB::select($this->query, [$this->getDatabase()]);
        }

        return collect($tables)->pluck('TABLE_NAME');
    }

    /**
     * Optimize the table
     *
     * @param  string $table
     * @return void
     */
    protected function optimize($table)
    {
        if (DB::statement("OPTIMIZE TABLE `{$table}`")){
            $this->progress->advance();
        }
    }
}
