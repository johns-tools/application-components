<?php

namespace JohnsTools\EventLogger\Controllers;

// Packages
use JohnsTools\EventLogger\EventLogger;

// Framework
use Illuminate\Routing\Controller;

class EventLogAdminController extends Controller
{

    public function __construct()
    {

    }

    public function viewLogs()
    {
        dump("Hello from the event log admin!");
    }
}
