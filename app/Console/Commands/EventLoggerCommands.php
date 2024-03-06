<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//
use JohnsTools\EventLogger\EventLogger;

class EventLoggerCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:event-logger-commands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eventLogger = new EventLogger();
    }
}
