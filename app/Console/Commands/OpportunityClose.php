<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OpportunityClose extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opp:close';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to close the opportunity';

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
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
