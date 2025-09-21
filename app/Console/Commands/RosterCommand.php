<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Roster\Roster;

class RosterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roster:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all packages in the roster';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Roster::scan()->packages()->unique(fn ($package) => $package->rawName())->each(function ($package) {
            echo '- '.$package->rawName().' (version '.$package->version().")\n";
        });
    }
}
