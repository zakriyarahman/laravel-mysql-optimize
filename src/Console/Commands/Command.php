<?php

namespace Zaks\MySQLOptimier\Console\Commands;

use Illuminate\Console\Command as BaseCommand;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Zaks\MySQLOptimier\Exceptions\DatabaseNotFoundException;
use Zaks\MySQLOptimier\Exceptions\TableNotFoundException;
use Exception;

class Command extends BaseCommand
{
    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Optimize table/s of the database';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'Table optimizer for database';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:optimize
                        {--database=default : Default database is set in the config. Database that needs to be optimized.}
                        {--table=* : Defaulting to all tables in the default database.}';

    /**
     * Construct
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->db = $builder;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Starting Optimization.');
        $this->getTables()
            ->tap(function($collection) {
                $this->progress = $this->output->createProgressBar($collection->count());
            })
            ->each(fn($table) => $this->optimize($table));
        $this->info(PHP_EOL.'Optimization Completed');
    }

    /**
     * Get database which need optimization
     *
     * @return string
     */
    protected function getDatabase(): string
    {
        $database = $this->option('database');
        if ($database == 'default') {
            return config('mysql-optimizer.database');
        }
        // Check if the database exists
        if (is_string($database) && $this->existsDatabase($database)) {
            return $database;
        }
        throw new DatabaseNotFoundException("This database {$database} doesn't exists.");
    }

    /**
     * Check if the database exists
     *
     * @param  string $databaseName
     * @return bool
     */
    private function existsDatabase(string &$databaseName): bool
    {
        return $this->db
                    ->newQuery()
                    ->selectRaw('SCHEMA_NAME')
                    ->fromRaw('INFORMATION_SCHEMA.SCHEMATA')
                    ->whereRaw("SCHEMA_NAME = '{$databaseName}'")
                    ->count();
    }

    /**
     * Get all the tables that need to the optimized
     *
     * @return Collection
     */
    private function getTables(): Collection
    {
        $tableList = collect($this->option('table'));
        if ($tableList->isEmpty()) {
            $tableList = $this->db
                ->newQuery()
                ->selectRaw('TABLE_NAME')
                ->fromRaw('INFORMATION_SCHEMA.TABLES')
                ->whereRaw("TABLE_SCHEMA = '{$this->getDatabase()}'")
                ->get();
            return $tableList->pluck('TABLE_NAME');
        }
        // Check if the table exists
        if ($this->existsTables($tableList)) {
            return $tableList;
        }
        throw new TableNotFoundException("One or more tables provided doesn't exists.");
    }

    /**
     * Check if the table exists
     *
     * @param  Collection $databaseName
     * @return bool
     */
    private function existsTables(Collection $tables): bool
    {
        return $this->db
                    ->newQuery()
                    ->fromRaw('INFORMATION_SCHEMA.TABLES')
                    ->whereRaw("TABLE_SCHEMA = '{$this->getDatabase()}'")
                    ->whereRaw('TABLE_NAME IN (\'' . $tables->implode("','") . '\')')
                    ->count() == $tables->count();
    }

    /**
     * Optimize the table
     *
     * @param  string $table
     * @return void
     */
    protected function optimize(string $table): void
    {
        $result = $this->db->getConnection()->select("OPTIMIZE TABLE `{$table}`");
        if (collect($result)->pluck('Msg_text')->contains('OK')) {
            $this->progress->advance();
        }
    }
}
