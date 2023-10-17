<?php

namespace App\Services\LoggingService;

// Utilities
use App\Services\LoggingService\Traits\Utilities as EventLoggerUtilities;

// Framework
use Exception;

class EventLogger
{

    use EventLoggerUtilities;

    // Class Instance
    protected $eventLoggerUtilities;
    protected $log_data;
    protected $events;

    protected $identifier;
    protected $storageDriver = 'system_event_logs';
    protected $fileName = null;
    protected $fileExtension = null;

    public function __construct(String $identifier, $storageDriver, Array $fileMeta)
    {
        // Check we have the required meta data, that will be used to create the file name.
        if(!isset($fileMeta['file_name']) or !isset($fileMeta['file_extension']))
        {
            throw new Exception("Missing required data from fileMeta.");
        }

        // Check an identifier is passed in, will be used when unique identity is required.
        if(!$identifier)
        {
            throw new Exception("Missing required parameter `identifier`.");
        }

        $this->identifier = $identifier;

        // After checking, we can now set the required variables local to this class instance.
        if($storageDriver)
        {
           $this->storageDriver = $storageDriver;
        }

        $this->fileName = $fileMeta['file_name'];
        $this->fileExtension = $fileMeta['file_extension'];

    }

    public function addEvent($class, $function, $message, $level)
    {
        $this->constructEvent(array_merge(
            $this->constructMetaData($class, $function),
            $this->constructMessage($message, $level)
        ));
    }
}
