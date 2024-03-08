<?php

namespace App\Console\Commands;

// Framework
use Illuminate\Console\Command;

// Package
use JohnsTools\EventLogger\EventLogger;

class EventLoggerCommands extends Command
{

    protected $signature   = 'app:event-logger-commands';
    protected $description = 'A command to interact with the event logger package.';

    public function handle()
    {
        $identity = uniqid();
        $storageDrive = 'system_event_logs';
        $fileMeta['file_name'] = "log_event_";
        $fileMeta['file_extension'] = ".json";

        $eventLogger = new EventLogger($identity, $storageDrive, $fileMeta);
        $eventLogger->addEvent(__CLASS__, __FUNCTION__, "Test Event", 0);
    }
}
