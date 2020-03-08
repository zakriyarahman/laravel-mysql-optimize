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
    protected $signature = 'database:optimize
                        {--database=default}
                        {--table=*?}';

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

    }

}
